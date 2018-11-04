package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.os.Looper;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.R;
import java.util.Random;

public class TwoFacAuthActivityController extends AppCompatActivity {
    Random rand = new Random();
    int genCode = rand.nextInt(899999)+100000;
    String [] UserInfo;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.twofacauthactivity);
        Bundle bundle = getIntent().getExtras();
        UserInfo = bundle.getStringArray("UserInfo");
        sendEmail(UserInfo[1]);
    }

    public void touchConfirm(View view) {
        EditText txtConfirm = findViewById(R.id.txtConfirm);
        String code = txtConfirm.getText().toString();
        if (code.equals(String.valueOf(genCode))) {
            Toast.makeText(this, "Authentication Confirmed", Toast.LENGTH_LONG).show();
            Bundle bundle = new Bundle();
            bundle.putStringArray("UserInfo", UserInfo);
            Intent intent = new Intent(this, RaceListActivityController.class);
            intent.putExtras(bundle);
            startActivity(intent);
            finish();
        }
        else {
            Toast.makeText(this, "Authentication Failed", Toast.LENGTH_LONG).show();
        }
    }

    public void sendEmail(String email) {
        DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
        Query query = reference.child("UserData").orderByChild("Email").equalTo(email);
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    for (DataSnapshot UserData : dataSnapshot.getChildren()) {
                        final String email = UserInfo[1];
                        if (!email.equals(UserData.child("Email").getValue())) {
                            displayFail();
                        }
                        else {
                            Thread thread = new Thread(new Runnable() {
                                @Override
                                public void run() {
                                    try {
                                        Looper.prepare();
                                        GMailSender sender = new GMailSender("CSCI3300SecurePoll@gmail.com", "SecurePollCSCI3300");
                                        sender.sendMail("Your SecurePoll Authentication Code",
                                                "Use this code: " + String.valueOf(genCode) + " to access your SecurePoll voting services",
                                                "CSCI3300SecurePoll@gmail.com",
                                                email);
                                    }catch (Exception e) {
                                        e.printStackTrace();
                                    }
                                }
                            });
                            thread.start();
                        }
                    }
                }
            }
            @Override
            public void onCancelled(DatabaseError databaseError) {
            }
        });
    }

    public void displayFail() {
        Toast.makeText(this, "Email not found", Toast.LENGTH_LONG).show();
    }
}