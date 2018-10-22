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
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.twofacauthactivity);
    }

    public void touchConfirm(View view) {
        EditText txtConfirm = findViewById(R.id.txtConfirm);
        String code = txtConfirm.getText().toString();
        if (code.equals(String.valueOf(genCode))) {
            Toast.makeText(this, "Authentication Confirmed", Toast.LENGTH_LONG).show();
            Intent intent = new Intent(this, RaceListActivityController.class);
            startActivity(intent);
        }
        else {
            Toast.makeText(this, "Authentication Failed", Toast.LENGTH_LONG).show();
        }
    }

    public void sendEmail(View view) {
        EditText txtEmail2Fac = findViewById(R.id.txtEmail2Fac);
        String email = txtEmail2Fac.getText().toString();
        DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
        Query query = reference.child("UserData").orderByChild("Email").equalTo(email);
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    for (DataSnapshot UserData : dataSnapshot.getChildren()) {
                        EditText txtEmail = findViewById(R.id.txtEmail2Fac);
                        final String email = txtEmail.getText().toString();
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
    public void displayFail()
    {
        Toast.makeText(this, "Email not found", Toast.LENGTH_LONG).show();
    }
}
