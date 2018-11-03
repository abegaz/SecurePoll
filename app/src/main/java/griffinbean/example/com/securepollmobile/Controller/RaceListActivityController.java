package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.*;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.R;

import java.util.ArrayList;
import java.util.List;


public class RaceListActivityController extends AppCompatActivity {
    String [] UserInfo;
    List<String> campList = new ArrayList<>();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.racelistactivity);
        TextView welcome = findViewById(R.id.txtWelcome);
        Bundle bundle = getIntent().getExtras();
        UserInfo = bundle.getStringArray("UserInfo");
        welcome.setText("Hello, " + UserInfo[0]);
        ListView campaignList = findViewById(R.id.campaignList);
        DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
        Query query = reference.child("CampaignData");
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    for (DataSnapshot CampaignData : dataSnapshot.getChildren()) {
                        if ((CampaignData.child("State").getValue().toString().equals(UserInfo[2]) ||
                                CampaignData.child("State").getValue().toString().equals("National")) && !CampaignData.hasChild(UserInfo[3])) {
                            campList.add(CampaignData.child("State").getValue().toString() + " "
                                    + CampaignData.child("Position").getValue().toString() + " "
                                    + CampaignData.child("Type").getValue().toString());
                        }
                    }
                }
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
            }

        });
        ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, campList );
        campaignList.setAdapter(arrayAdapter);

        campaignList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapter, View view, final int position, long arg) {
                DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
                Query query = reference.child("CampaignData");
                query.addListenerForSingleValueEvent(new ValueEventListener() {
                    @Override
                    public void onDataChange(DataSnapshot dataSnapshot) {
                        if (dataSnapshot.exists()) {
                            for (DataSnapshot CampaignData : dataSnapshot.getChildren()) {
                                if ((CampaignData.child("State").getValue().toString() + " "
                                        + CampaignData.child("Position").getValue().toString() + " "
                                        + CampaignData.child("Type").getValue().toString()).equals(campList.get(position))) {
                                    String [] CampaignInfo = {  CampaignData.child("State").getValue().toString(),
                                                                CampaignData.child("Position").getValue().toString(),
                                                                CampaignData.child("Type").getValue().toString(),
                                                                CampaignData.child("CampID").getValue().toString()
                                    };
                                    Bundle bundle = new Bundle();
                                    bundle.putStringArray("UserInfo", UserInfo);
                                    bundle.putStringArray("CampaignInfo", CampaignInfo);
                                    Intent intent = new Intent(RaceListActivityController.this, CampaignItemActivityController.class);
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

