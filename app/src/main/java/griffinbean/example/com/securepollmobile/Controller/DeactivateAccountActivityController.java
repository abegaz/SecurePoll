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

public class DeactivateAccountActivityController extends AppCompatActivity {

    DatabaseReference reference = FirebaseDatabase.getInstance().getReference();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.deactivateaccountactivity);
    }

    /**
     *  Confirms the user has input their proper login credentials, validates and throws error if they have not,
     *  displays confirmation dialog box before the account is deactivated
     */
    public void touchDeac(View view) {
        ConfirmDialogClass cdd = new ConfirmDialogClass(DeactivateAccountActivityController.this);
        cdd.show();
        cdd.confirm.setText("Are you sure you want to deactivate your account?");
        cdd.yes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText txtEmail = findViewById(R.id.txtDeacEmail);
                String inputEmail = txtEmail.getText().toString();

                Query query = reference.child("UserData").orderByChild("Email").equalTo(inputEmail);
                query.addListenerForSingleValueEvent(new ValueEventListener() {
                    @Override
                    public void onDataChange(DataSnapshot dataSnapshot) {
                        if (dataSnapshot.exists()) {
                            for (DataSnapshot UserData : dataSnapshot.getChildren()) {
                                EditText txtEmail = findViewById(R.id.txtDeacEmail);
                                EditText txtPassword = findViewById(R.id.txtDeacPassword);
                                String inputEmail = txtEmail.getText().toString();
                                String inputPass = getSecurePassword(txtPassword.getText().toString() + UserData.child("PassSalt").getValue().toString());
                                if (inputEmail.equals(UserData.child("Email").getValue()) && (inputPass.equals(UserData.child("Password").getValue()))) {
                                    String UID = UserData.child("UserID").getValue().toString();
                                    reference.child("UserData").child(UID).child("Status").setValue("na");
                                    Intent intent = new Intent(DeactivateAccountActivityController.this, LoginActivityController.class);
                                    startActivity(intent);
                                    finish();
                                }
                                else {
                                    Toast.makeText(DeactivateAccountActivityController.this, "The username or password is incorrect", Toast.LENGTH_LONG).show();
                                }
                            }
                        }
                    }
                    @Override
                    public void onCancelled(DatabaseError databaseError) {
                    }
                });
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
}