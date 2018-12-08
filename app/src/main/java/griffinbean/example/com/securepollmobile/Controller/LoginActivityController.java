package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.R;
import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class LoginActivityController extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loginactivity);
    }

    /**
     *  Checks Firebase Database for proper authentication based on the user-supplied email, displays error messages
     *  if password or email is invalid, or if the account has been deactivated. On successful login, moves to
     *  2-Factor authentication activity and persists user data
     */
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
                        String inputPass = getSecurePassword(txtPassword.getText().toString() + UserData.child("PassSalt").getValue().toString());
                        if ((inputEmail.equals(UserData.child("Email").getValue())) && (inputPass.equals(UserData.child("Password").getValue())) &&
                                (UserData.child("Status").getValue().toString().equals("na"))){
                            displayDeac();
                        }
                        if ((inputEmail.equals(UserData.child("Email").getValue())) && (inputPass.equals(UserData.child("Password").getValue())) &&
                                (UserData.child("Status").getValue().toString().equals("a"))) {
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

    /**
     *  Displays confirmation and starts TwoFacAuthActivityController
     */
    public void displayConfirm(String [] ud) {
        Bundle bundle = new Bundle();
        bundle.putStringArray("UserInfo", ud);
        Toast.makeText(this, "Logged-in", Toast.LENGTH_LONG).show();
        Intent intent = new Intent(this, TwoFacAuthActivityController.class);
        intent.putExtras(bundle);
        startActivity(intent);
        finish();
    }

    /**
     *  Displays an error if login information is incorrect
     */
    public void displayFail() {
        Toast.makeText(this, "Your Email or Password was incorrect, please try again", Toast.LENGTH_LONG).show();
    }

    /**
     *  Displays error if account has been deactivated
     */
    public void displayDeac() {
        Toast.makeText(this, "Your Account has been Deactivated, please contact a SecurePoll administrator to reactivate it", Toast.LENGTH_LONG).show();
    }

    /**
     *  For password validation and confirmation
     */
    public String getSecurePassword(String passwordToHash){
        String generatedPassword = null;
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-512");
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

    /**
     *  Send to Change Password activity
     */
    public void touchChangePass(View view) {
        Intent intent = new Intent(this, ChangePasswordActivityController.class);
        startActivity(intent);
        finish();
    }

    /**
     *  Send to Deactivate Account activity
     */
    public void touchDeactivate(View view) {
        Intent intent = new Intent(this, DeactivateAccountActivityController.class);
        startActivity(intent);
        finish();
    }
}