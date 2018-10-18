package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;

import griffinbean.example.com.securepollmobile.R;

import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.util.Random;

public class RegisterActivityController extends AppCompatActivity {
    int i = 0;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        i++;
        super.onCreate(savedInstanceState);
        setContentView(R.layout.registeractivity);
    }

    public void touchRegister(View view) {
        String userID = String.valueOf(i);
        EditText txtFname = findViewById(R.id.txtFname);
        EditText txtLname = findViewById(R.id.txtLname);
        EditText txtState = findViewById(R.id.txtState);
        EditText txtDob = findViewById(R.id.txtDoB);
        EditText txtSSN = findViewById(R.id.txtSSN);
        EditText txtVoterID = findViewById(R.id.txtVoterID);
        EditText txtEmail = findViewById(R.id.txtEmail);
        EditText txtPassword = findViewById(R.id.txtPassword);
        String PassSalt = generateRandomSalt(100);
        String EmailSalt = generateRandomSalt(100);
        String SSNSalt = generateRandomSalt(100);

        DatabaseReference mDatabase;
        mDatabase = FirebaseDatabase.getInstance().getReference().child("UserData").child(userID);

        mDatabase.child("UserID").setValue(userID);
        mDatabase.child("FName").setValue(txtFname.getText().toString());
        mDatabase.child("LName").setValue(txtLname.getText().toString());
        mDatabase.child("DoB").setValue(txtDob.getText().toString());
        mDatabase.child("State").setValue(txtState.getText().toString());
        if (txtSSN.length() == 4){
            mDatabase.child("SSN").setValue(getSecurePassword(txtSSN.getText().toString(), SSNSalt));}
         else{

        }
        mDatabase.child("VoterIDNum").setValue(txtVoterID.getText().toString());
        mDatabase.child("Email").setValue(getSecurePassword(txtEmail.getText().toString(), EmailSalt));
        mDatabase.child("Password").setValue(getSecurePassword(txtPassword.getText().toString(), PassSalt));
        mDatabase.child("PassSalt").setValue(PassSalt);
        mDatabase.child("EmailSalt").setValue(PassSalt);
        mDatabase.child("SSNSalt").setValue(PassSalt);

        Intent intent = new Intent(this, RaceListActivityController.class);
        startActivity(intent);
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
    static final String AlphaNum = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    static SecureRandom randomSalt = new SecureRandom();

    String generateRandomSalt(int len ){
        StringBuilder sb = new StringBuilder(len);
        for( int i = 0; i < len; i++ )
            sb.append( AlphaNum.charAt( randomSalt.nextInt(AlphaNum.length()) ));
        return sb.toString();
    }

}

