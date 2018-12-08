package griffinbean.example.com.securepollmobile.Controller;

import android.graphics.Color;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import com.github.mikephil.charting.charts.PieChart;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.data.PieData;
import com.github.mikephil.charting.data.PieDataSet;
import com.github.mikephil.charting.formatter.PercentFormatter;
import com.github.mikephil.charting.utils.ColorTemplate;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.R;
import java.util.ArrayList;

public class CampaignResultActivityController extends AppCompatActivity {
    String [] UserInfo;
    String [] CampaignInfo;
    PieChart piechart;
    ArrayList<Entry> votes = new ArrayList<>();
    ArrayList<String> names = new ArrayList<>();
    DatabaseReference reference = FirebaseDatabase.getInstance().getReference();

    /**
     *  Creates and populates a donut chart based on the persistent campaign data given to it
     */
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.campaignresultactivity);
        Bundle bundle = getIntent().getExtras();
        UserInfo = bundle.getStringArray("UserInfo");
        CampaignInfo = bundle.getStringArray("CampaignInfo");
        piechart = findViewById(R.id.piechart);
        piechart.setUsePercentValues(true);
        Query query = reference.child("CandidateData");
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                int i = 0;
                if (dataSnapshot.exists()) {
                    for (DataSnapshot CandidateData : dataSnapshot.getChildren()) {
                        if (CandidateData.child("CampaignID").getValue().toString().equals(CampaignInfo[3])) {
                            float canVotes = Integer.parseInt(CandidateData.child("VoteCount").getValue().toString());
                            String name = CandidateData.child("FName").getValue().toString() + " " + CandidateData.child("LName").getValue().toString();
                            names.add(name);
                            votes.add(new Entry(canVotes, i));
                            i++;
                        }
                    }
                    makeChart();
                }
            }
            @Override
            public void onCancelled(DatabaseError databaseError) {
            }
        });
    }

    /**
     *  Chart formatting and creation
     */
    public void makeChart()
    {
        PieDataSet dataSet = new PieDataSet(votes, "");
        PieData data = new PieData(names, dataSet);
        data.setValueFormatter(new PercentFormatter());
        piechart.setData(data);
        piechart.setDescription("");
        piechart.invalidate();
        dataSet.setColors(ColorTemplate.COLORFUL_COLORS);
        data.setValueTextSize(20f);
        data.setValueTextColor(Color.BLACK);
        piechart.getLegend().setEnabled(false);
    }
}