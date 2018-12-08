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
import java.security.SecureRandom;

public class ChangePasswordActivityController extends AppCompatActivity {

    static final String AlphaNum = "1234567890qwertyuiop";
    static SecureRandom randomSalt = new SecureRandom();
    DatabaseReference reference = FirebaseDatabase.getInstance().getReference();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.changepasswordactivity);
    }

    /**
     *  Ensures the user has input their correct login credentials, validates the new password is input twice and
     *  is properly formatted
     */
    public void touchUpdate(View view) {
        final String PassSalt = AlphaNum + generateRandomSalt(14);
        EditText txtEmail = findViewById(R.id.txtUpdEmail);
        String inputEmail = txtEmail.getText().toString();

        Query query = reference.child("UserData").orderByChild("Email").equalTo(inputEmail);
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    for (DataSnapshot UserData : dataSnapshot.getChildren()) {
                        EditText txtEmail = findViewById(R.id.txtUpdEmail);
                        EditText txtPassword = findViewById(R.id.txtUpdPassword);
                        String inputEmail = txtEmail.getText().toString();
                        String inputPass = getSecurePassword(txtPassword.getText().toString() + UserData.child("PassSalt").getValue().toString());
                        if (inputEmail.equals(UserData.child("Email").getValue()) && (inputPass.equals(UserData.child("Password").getValue()))) {
                            String UID = UserData.child("UserID").getValue().toString();
                            EditText txtNewPass = findViewById(R.id.txtUpdPassword2);
                            EditText txtConfirmNewPass = findViewById(R.id.txtConfirmPassword);
                            if (txtNewPass.getText().toString().equals(txtConfirmNewPass.getText().toString())) {
                                String newPass = txtNewPass.getText().toString();
                                if (validatePassword(newPass)) {
                                    reference.child("UserData").child(UID).child("PassSalt").setValue(PassSalt);
                                    reference.child("UserData").child(UID).child("Password").setValue(getSecurePassword(newPass + PassSalt));
                                    Intent intent = new Intent(ChangePasswordActivityController.this, LoginActivityController.class);
                                    startActivity(intent);
                                    finish();
                                }
                            }
                            else
                            {
                                Toast.makeText(ChangePasswordActivityController.this, "The new passwords do not match", Toast.LENGTH_LONG).show();
                            }
                        }
                        else
                        {
                            Toast.makeText(ChangePasswordActivityController.this, "The username or password is incorrect", Toast.LENGTH_LONG).show();
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
     *  For password generation and confirmation
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
     *  For password generation
     */
    String generateRandomSalt(int len) {
        StringBuilder sb = new StringBuilder(len);
        for (int i = 0; i < len; i++)
            sb.append(AlphaNum.charAt(randomSalt.nextInt(AlphaNum.length())));
        return sb.toString();
    }

    /**
     *  Validates the password is the proper format
     */
    private boolean validatePassword(String password) {
        if (password.matches("(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&]).*")) {
            return true;
        }
        else {
            Toast.makeText(this, "Password should be at least 8 characters long and contain at " +
                    "least 1 Uppercase letter, 1 Lowercase letter, 1 digit, and 1 special character", Toast.LENGTH_LONG).show();
            return false;
        }
    }
}