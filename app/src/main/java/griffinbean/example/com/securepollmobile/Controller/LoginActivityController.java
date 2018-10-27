package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.Model.User;
import griffinbean.example.com.securepollmobile.R;

import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class LoginActivityController extends AppCompatActivity
{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loginactivity);
    }

    public void touchLogin(View view) {
        EditText txtEmail = findViewById(R.id.txtEmailLog);
        String inputEmail = txtEmail.getText().toString();
        DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
        Query query = reference.child("UserData").orderByChild("Email").equalTo(inputEmail);
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    for (DataSnapshot UserData : dataSnapshot.getChildren()) {
                        EditText txtEmail = findViewById(R.id.txtEmailLog);
                        EditText txtPassword = findViewById(R.id.txtPasswordLog);
                        String inputEmail = txtEmail.getText().toString();
                        String inputPass = getSecurePassword(txtPassword.getText().toString(), UserData.child("PassSalt").getValue().toString());
                        if (inputEmail.equals(UserData.child("Email").getValue())
                                && (inputPass + UserData.child("PassSalt").getValue()).equals(UserData.child("Password").getValue())) {
                            String [] UserInfo = {  UserData.child("FName").getValue().toString(),
                                                    UserData.child("Email").getValue().toString(),
                                                    UserData.child("State").getValue().toString(),
                                                    UserData.child("UserID").getValue().toString()
                                                };
                            displayConfirm(UserInfo);
                        }
                        else {
                            displayFail();
                        }
                    }
                }
            }
            @Override
            public void onCancelled(DatabaseError databaseError) {
            }
        });
    }

    public void displayConfirm(String [] ud)
    {
        Bundle bundle = new Bundle();
        bundle.putStringArray("UserInfo", ud);
        Toast.makeText(this, "Logged-in", Toast.LENGTH_LONG).show();
        Intent intent = new Intent(this, TwoFacAuthActivityController.class);
        intent.putExtras(bundle);
        startActivity(intent);
    }

    public void displayFail()
    {
        Toast.makeText(this, "Your Email or Password was incorrect, please try again", Toast.LENGTH_LONG).show();
    }

    public String getSecurePassword(String passwordToHash, String messageSalt){
        String generatedPassword = null;
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-512");
            md.update(messageSalt.getBytes(Charset.forName("UTF-8")));
            byte[] bytes = md.digest(passwordToHash.getBytes(Charset.forName("UTF-8")));
            StringBuilder sb = new StringBuilder();
            for(int i=0; i< bytes.length ;i++){
                sb.append(Integer.toString((bytes[i] & 0xff) + 0x100, 16).substring(1));
            }
            generatedPassword = sb.toString();
        }
        catch (NoSuchAlgorithmException e){
            e.printStackTrace();
        }
        return generatedPassword;
    }
}

