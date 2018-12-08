package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.R;

public class CampaignItemActivityController extends AppCompatActivity {
    String [] UserInfo;
    String [] CampaignInfo;
    DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
    int votesNum;

    /**
     *  Generates and populates a radio button group based on the persistent campaign data given
     */
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.campaignitem);
        Bundle bundle = getIntent().getExtras();
        UserInfo = bundle.getStringArray("UserInfo");
        CampaignInfo = bundle.getStringArray("CampaignInfo");
        final RadioGroup candidateGroup = findViewById(R.id.candidateGroup);
        Query query = reference.child("CandidateData");
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                int i = 0;
                if (dataSnapshot.exists()) {
                    for (DataSnapshot CandidateData : dataSnapshot.getChildren()) {
                        if (CandidateData.child("CampaignID").getValue().toString().equals(CampaignInfo[3])) {
                            i++;
                            RadioButton rdbtn = new RadioButton(CampaignItemActivityController.this);
                            rdbtn.setId(i);
                            rdbtn.setText(CandidateData.child("FName").getValue().toString() + " "
                            + CandidateData.child("LName").getValue().toString() + " ("
                            + CandidateData.child("Party").getValue().toString() + ")");
                            candidateGroup.addView(rdbtn);
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
     *  Validates a candidate has been selected, prompts the user to confirm with a dialog box before
     *  submitting the vote to the database. Increments the vote tally of the candidate being voted for. User's
     *  id and email are added to the campaign's data so they cannot vote in it again
     */
    public void touchConfirm(View view) {
        final RadioGroup candidateGroup = findViewById(R.id.candidateGroup);
        int selectedRB = candidateGroup.getCheckedRadioButtonId();
        final RadioButton selected = findViewById(selectedRB);
        if (candidateGroup.getCheckedRadioButtonId() == -1) {
            Toast.makeText(this, "Please Select a Candidate before continuing", Toast.LENGTH_LONG).show();
        }
        else {
            ConfirmDialogClass cdd = new ConfirmDialogClass(CampaignItemActivityController.this);
            cdd.show();
            cdd.confirm.setText("Confirm this is who you want to vote for\nThis cannot be changed later\n" + selected.getText());
            cdd.yes.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Query query = reference.child("CandidateData");
                    query.addListenerForSingleValueEvent(new ValueEventListener() {
                        @Override
                        public void onDataChange(DataSnapshot dataSnapshot) {
                            if (dataSnapshot.exists()) {
                                for (DataSnapshot CandidateData : dataSnapshot.getChildren()) {
                                    if ((CandidateData.child("FName").getValue().toString() + " "
                                            + CandidateData.child("LName").getValue().toString() + " ("
                                            + CandidateData.child("Party").getValue().toString() + ")").equals(selected.getText())) {
                                        String votes = CandidateData.child("VoteCount").getValue().toString();
                                        votesNum = Integer.parseInt(votes);
                                        votesNum++;
                                        reference.child("CandidateData").child(CandidateData.child(
                                                "CandidateID").getValue().toString()).child("VoteCount").setValue(votesNum);
                                        reference.child("CampaignData").child(CampaignInfo[3]).child(UserInfo[3]).setValue(UserInfo[1]);
                                        Bundle bundle = new Bundle();
                                        bundle.putStringArray("UserInfo", UserInfo);
                                        bundle.putStringArray("CampaignInfo", CampaignInfo);
                                        Intent intent = new Intent(CampaignItemActivityController.this, RaceListActivityController.class);
                                        intent.putExtras(bundle);
                                        startActivity(intent);
                                        finish();
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
    }
}