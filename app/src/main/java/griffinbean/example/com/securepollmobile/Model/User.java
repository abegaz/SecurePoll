package griffinbean.example.com.securepollmobile.Model;

import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;

public class User
{
    private String userID;
    private String firstName;
    private String lastName;
    private String dateOfBirth;
    private String state;
    private String SSN;
    private String voterID;
    private String email;
    private String password;

    public User() {

    }

    public User(String userID, String firstName, String lastName, String dateOfBirth, String state, String SSN, String voterID, String email, String password)
    {
        this.userID = userID;
        this.firstName = firstName;
        this.lastName = lastName;
        this.dateOfBirth = dateOfBirth;
        this.state = state;
        this.SSN = SSN;
        this.voterID = voterID;
        this.email = email;
        this.password = password;
    }

    /**
     *  Retrives a Firebase reference for a specific User under the UserData child
     */
    public DatabaseReference getFirebaseRefforUser(String i)
    {
        DatabaseReference mDatabase;
        mDatabase = FirebaseDatabase.getInstance().getReference().child("UserData").child(i);
        return mDatabase;
    }

    /**
     *  Creates a new child under the reference passed to it, adds relevant values based on a User object and
     *  other strings not assigned by User input
     */
    public void insertUsertoFirebase(DatabaseReference m, User u, String passSalt, String ssnSalt)
    {
        m.child("UserID").setValue(u.getUserID());
        m.child("FName").setValue(u.getFirstName());
        m.child("LName").setValue(u.getLastName());
        m.child("DoB").setValue(u.getDateOfBirth());
        m.child("State").setValue(u.getState());
        m.child("SSN").setValue(u.getSSN());
        m.child("VoterIDNum").setValue(u.getVoterID());
        m.child("Email").setValue(u.getEmail());
        m.child("Password").setValue(u.getPassword());
        m.child("PassSalt").setValue(passSalt);
        m.child("SSNSalt").setValue(ssnSalt);
        m.child("Status").setValue("a");
    }

    public String getUserID() {
        return userID;
    }

    public void setUserID(String userID) {
        this.userID = userID;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getDateOfBirth() {
        return dateOfBirth;
    }

    public void setDateOfBirth(String dateOfBirth) {
        this.dateOfBirth = dateOfBirth;
    }

    public String getState() {
        return state;
    }

    public void setState(String state) {
        this.state = state;
    }

    public String getSSN() {
        return SSN;
    }

    public void setSSN(String SSN) {
        this.SSN = SSN;
    }

    public String getVoterID() {
        return voterID;
    }

    public void setVoterID(String voterID) {
        this.voterID = voterID;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }
}