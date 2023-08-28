<?php

namespace App\Helpers\ManageSection;

use App\Helpers\BaseHelper;
use Illuminate\Support\Facades\Log;


class Helper extends BaseHelper
{
    protected $_client_public_files_module_dir_name = 'frontend';


    const MORNING = 'Morning';
    const AFTERNOON = 'AfterNoon';
    const EVENING = 'Evening';

    const BLOOD_PRESSURE_NORMAL = "Normal";
    const BLOOD_PRESSURE_HIGH = "High";
    const BLOOD_PRESSURE_LOW = "Low";
    const BLOOD_PRESSURE_CONTOLLERD_WITH = "Controlled With";
    const BLOOD_PRESSURE_UNKNOWN = "Unknown";


    const BLOOD_PRESSURE_MEDICATION_LISINOPRIL = "Lisinopril";
    const BLOOD_PRESSURE_MEDICATION_METOPROLOL = "Metoprolol";
    const BLOOD_PRESSURE_MEDICATION_HYDROCHLOROTHIAZIDE = "Hydrochlorothiazide";
    const BLOOD_PRESSURE_MEDICATION_AMLODIPINE = "Amlodipine";
    const BLOOD_PRESSURE_MEDICATION_OTHER = "Other";


    const MEDICATIONS_CONJUNCTION_1 = "Nitrograd";
    const MEDICATIONS_CONJUNCTION_2 = "Nitroglycerin";
    const MEDICATIONS_CONJUNCTION_3 = "Sildenafil ";
    const MEDICATIONS_CONJUNCTION_4 = "Medicine";
    const MEDICATIONS_CONJUNCTION_5 = "Adempas";
    const MEDICATIONS_CONJUNCTION_6 = "Isosorbide";
    const MEDICATIONS_CONJUNCTION_7 = "None apply";

    const DRUGS_1 = "Poppers or Rush Amy Nitrate or Butyl Nitrate ";
    const DRUGS_2 = "Cocaine";
    const DRUGS_3 = "QO None Apply";
    const DRUGS_4 = "None apply";

    const TREAT_1 = "Cardiovascular";
    const TREAT_2 = "Diabetes";
    const TREAT_3 = "Thyroid";
    const TREAT_4 = "Cholesterol";
    const TREAT_5 = "Lung";
    const TREAT_6 = "Gastroesophageal";
    const TREAT_7 = "Attention deficit";
    const TREAT_8 = "Other";

    const CARDIOVASCULAR_1 = "Isosorbide";
    const CARDIOVASCULAR_2 = "Nitrates";
    const CARDIOVASCULAR_3 = "Atorvastatin";
    const CARDIOVASCULAR_4 = "Warfarin";
    const CARDIOVASCULAR_5 = "Other";

    const DIABETES_1 = "Lantus";
    const DIABETES_2 = "Lyrica";
    const DIABETES_3 = "Januvia";
    const DIABETES_4 = "NovoLog";
    const DIABETES_5 = "Humalog®";
    const DIABETES_6 = "Metformin";
    const DIABETES_7 = "Glipizide";
    const DIABETES_8 = "Other";

    const DIABETES_LEVEL_1 = "5.7";
    const DIABETES_LEVEL_2 = "6.4";
    const DIABETES_LEVEL_3 = "7.5";
    const DIABETES_LEVEL_4 = "7.5 and above";

    const THYROID_1 = "Levothyroxine (synthroid, levothyroid,levoxyl, unithroid)";
    const THYROID_2 = "Liothyronine (cytomel)";
    const THYROID_3 = "Liotrix (thyrolar)";
    const THYROID_4 = " Natural thyroid (armour thyroid, nature-throid, westhroid)";
    const THYROID_5 = "Other";

    const CHOLESTEROL_1 = "Crestor";
    const CHOLESTEROL_2 = "Atorvastatin";
    const CHOLESTEROL_3 = "Fluvastatin";
    const CHOLESTEROL_4 = "Pitavastatin";
    const CHOLESTEROL_5 = "Pravastatin";
    const CHOLESTEROL_6 = "Other";

    const BEWATHING_1 = "Ventolin HFA";
    const BEWATHING_2 = "Advair Diskus";
    const BEWATHING_3 = "Spiriva Handihaler";
    const BEWATHING_4 = "Other";

    const  GASTROESOPHAGEAL_1 = "Nexium";
    const  GASTROESOPHAGEAL_2 = "Rabeprazole";
    const  GASTROESOPHAGEAL_3 = "Lansoprazole";
    const  GASTROESOPHAGEAL_4 = "Omeprazole";
    const  GASTROESOPHAGEAL_5 = "Other";

    const HYPERACTIVITY_1 = "Exedrine";
    const HYPERACTIVITY_2 = "Adderall";
    const HYPERACTIVITY_3 = "Ritalin";
    const HYPERACTIVITY_4 = "Concerta";
    const HYPERACTIVITY_5 = "Other";

    const TREAT_WITH_1 = "Viagra";
    const TREAT_WITH_2 = "Levitra";
    const TREAT_WITH_3 = "Cialis";
    const TREAT_WITH_4 = "Other";

    const CONFIDENCE_RATE_1 = "Very Low";
    const CONFIDENCE_RATE_2 = "Low";
    const CONFIDENCE_RATE_3 = "Moderate";
    const CONFIDENCE_RATE_4 = "High";
    const CONFIDENCE_RATE_5 = "Very High";

    const SEXUAL_STIMULATION_1 = "Almost never";
    const SEXUAL_STIMULATION_2 = "A few times";
    const SEXUAL_STIMULATION_3 = "Sometimes";
    const SEXUAL_STIMULATION_4 = "Most times";
    const SEXUAL_STIMULATION_5 = "Almost always";

    const SEXUAL_DIFICULT_1 = "Extremely";
    const SEXUAL_DIFICULT_2 = "Very";
    const SEXUAL_DIFICULT_3 = "Difficult";
    const SEXUAL_DIFICULT_4 = "Slightly";
    const SEXUAL_DIFICULT_5 = "Not Difficult";


    const PRIMARY_HEALTH_GOAL_1 = "I feel optimal";
    const PRIMARY_HEALTH_GOAL_2 = "Loss Weight";
    const PRIMARY_HEALTH_GOAL_3 = "Endurance & Length";
    const PRIMARY_HEALTH_GOAL_4 = "Improve Libido";
    const PRIMARY_HEALTH_GOAL_5 = "Improve Energy";
    const PRIMARY_HEALTH_GOAL_6 = "Better Sleep";
    const PRIMARY_HEALTH_GOAL_7 = "Other";

    const ENERGY_1 = "Optimal";
    const ENERGY_2 = "Improvad";
    const ENERGY_3 = "No Change";
    const ENERGY_4 = "Worse";

    const SYMPTOM_1 = "None";
    const SYMPTOM_2 = "Mild";
    const SYMPTOM_3 = "Moderate";
    const SYMPTOM_4 = "Servere";

    const EXPERIENCE_1 = "1";
    const EXPERIENCE_2 = "2";
    const EXPERIENCE_3 = "3";
    const EXPERIENCE_4 = "4";
    const EXPERIENCE_5 = "5";
    const EXPERIENCE_6 = "6";
    const EXPERIENCE_7 = "7";
    const EXPERIENCE_8 = "8";
    const EXPERIENCE_9 = "9";
    const EXPERIENCE_10 = "10";

    protected $_helper;

    public function __construct()
    {
    }



    public function getGender()
    {
        return $this->gender();
    }

    public function getWeekday()
    {
        return [
            ['key' => self::MORNING, 'value' => self::MORNING, 'label' => self::MORNING],
            ['key' => self::AFTERNOON, 'value' => self::AFTERNOON, 'label' => self::AFTERNOON],
            ['key' => self::EVENING, 'value' => self::EVENING, 'label' => self::EVENING],
        ];
    }

    public function getWeekend()
    {
        return [
            ['key' => self::MORNING, 'value' => self::MORNING, 'label' => self::MORNING],
            ['key' => self::AFTERNOON, 'value' => self::AFTERNOON, 'label' => self::AFTERNOON],
            ['key' => self::EVENING, 'value' => self::EVENING, 'label' => self::EVENING],
        ];
    }

    public function getBloodPressure()
    {
        return [
            ['key' => self::BLOOD_PRESSURE_NORMAL, 'value' => self::BLOOD_PRESSURE_NORMAL, 'label' => self::BLOOD_PRESSURE_NORMAL],
            ['key' => self::BLOOD_PRESSURE_HIGH, 'value' => self::BLOOD_PRESSURE_HIGH, 'label' => self::BLOOD_PRESSURE_HIGH],
            ['key' => self::BLOOD_PRESSURE_LOW, 'value' => self::BLOOD_PRESSURE_LOW, 'label' => self::BLOOD_PRESSURE_LOW],
            ['key' => self::BLOOD_PRESSURE_CONTOLLERD_WITH, 'value' => self::BLOOD_PRESSURE_CONTOLLERD_WITH, 'label' => self::BLOOD_PRESSURE_CONTOLLERD_WITH],
            ['key' => self::BLOOD_PRESSURE_UNKNOWN, 'value' => self::BLOOD_PRESSURE_UNKNOWN, 'label' => self::BLOOD_PRESSURE_UNKNOWN],
        ];
    }

    public function getBloodPressureMedication()
    {

        return [
            ['key' => self::BLOOD_PRESSURE_MEDICATION_LISINOPRIL, 'value' => self::BLOOD_PRESSURE_MEDICATION_LISINOPRIL, 'label' => 'Lisinopril (Prinivil, Zestril)'],
            ['key' => self::BLOOD_PRESSURE_MEDICATION_METOPROLOL, 'value' => self::BLOOD_PRESSURE_MEDICATION_METOPROLOL, 'label' => 'Metoprolol (Lopressor, Toprol XL)'],
            ['key' => self::BLOOD_PRESSURE_MEDICATION_HYDROCHLOROTHIAZIDE, 'value' => self::BLOOD_PRESSURE_MEDICATION_HYDROCHLOROTHIAZIDE, 'label' => 'Hydrochlorothiazide (Esidrix, Hydrodiuril) Losartan (Cozaar)'],
            ['key' => self::BLOOD_PRESSURE_MEDICATION_AMLODIPINE, 'value' => self::BLOOD_PRESSURE_MEDICATION_AMLODIPINE, 'label' => 'Amlodipine (Norvasc, Lotrel) Diltiazem (Cardizem, Tiazac)'],
            ['key' => self::BLOOD_PRESSURE_MEDICATION_OTHER, 'value' => self::BLOOD_PRESSURE_MEDICATION_OTHER, 'label' => 'Other'],
        ];
    }

    public function getMedicationsConjunction()
    {
        return [
            ['key' => self::MEDICATIONS_CONJUNCTION_1, 'value' => self::MEDICATIONS_CONJUNCTION_1, 'label' => 'Nitrograd, Nitroglyn, Nitrol, Nitrolingua,
                                            Nitrolingual, NitroMist, Nitrong, Nitronol,
                                            Nitro-Par, Nitroquick, Nitrostat, Nitrotab,
                                            Nitro-Time, Transdermal-Nitro'],
            ['key' => self::MEDICATIONS_CONJUNCTION_2, 'value' => self::MEDICATIONS_CONJUNCTION_2, 'label' => 'Nitroglycerin in any form - as a spray,
                                            tablet, patch or ointment. Deponit, Minitran,
                                            Nitrek, Nitro-Bid, Nircot, Nitrodisc, Niro-Dur'],
            ['key' => self::MEDICATIONS_CONJUNCTION_3, 'value' => self::MEDICATIONS_CONJUNCTION_3, 'label' => ' Sildenafil (Revatio) used to treat pulmonary
                                            hypertension'],
            ['key' => self::MEDICATIONS_CONJUNCTION_4, 'value' => self::MEDICATIONS_CONJUNCTION_4, 'label' => 'Medicine containing nitrates'],
            ['key' => self::MEDICATIONS_CONJUNCTION_5, 'value' => self::MEDICATIONS_CONJUNCTION_5, 'label' => 'Adempas (Riociquat), which is used to
                                            treat pulmonary hypertension.'],
            ['key' => self::MEDICATIONS_CONJUNCTION_6, 'value' => self::MEDICATIONS_CONJUNCTION_6, 'label' => 'Isosorbide Mononitrate or Isosorbide
                                            Dinitrate (Dilatrate, Dilatrate-SR, Imdur,
                                            Ismo, Isordil, Monoket, Sorbitrate)'],
            ['key' => self::MEDICATIONS_CONJUNCTION_7, 'value' => self::MEDICATIONS_CONJUNCTION_7, 'label' => 'None apply'],
        ];
    }

    public function getRecreationalDrugs()
    {
        return [
            ['key' => self::DRUGS_1, 'value' => self::DRUGS_1, 'label' => self::DRUGS_1],
            ['key' => self::DRUGS_2, 'value' => self::DRUGS_2, 'label' => self::DRUGS_2],
            ['key' => self::DRUGS_3, 'value' => self::DRUGS_3, 'label' => self::DRUGS_3],
            ['key' => self::DRUGS_4, 'value' => self::DRUGS_4, 'label' => self::DRUGS_4],
        ];
    }

    public function getTreat()
    {
        return [
//            ['key' => self::TREAT_1, 'value' => self::TREAT_1, 'label' => 'Cardiovascular disease (Heart) (Excluding Blood Pressure)'],
            ['key' => self::TREAT_2, 'value' => self::TREAT_2, 'label' => 'Diabetes'],
            ['key' => self::TREAT_3, 'value' => self::TREAT_3, 'label' => 'Thyroid'],
            ['key' => self::TREAT_4, 'value' => self::TREAT_4, 'label' => 'Cholesterol'],
            ['key' => self::TREAT_5, 'value' => self::TREAT_5, 'label' => 'Lung'],
//            ['key' => self::TREAT_6, 'value' => self::TREAT_6, 'label' => 'Gastroesophageal reflux'],
//            ['key' => self::TREAT_7, 'value' => self::TREAT_7, 'label' => 'Attention deficit hyperactivity disorder Other (ADHD)'],
            ['key' => self::TREAT_8, 'value' => self::TREAT_8, 'label' => 'Other'],
        ];
    }

    public function getCardiovascular()
    {
        return [
            ['key' => self::CARDIOVASCULAR_1, 'value' => self::CARDIOVASCULAR_1, 'label' => 'Isosorbide dinitrate (Isordil)'],
            ['key' => self::CARDIOVASCULAR_2, 'value' => self::CARDIOVASCULAR_2, 'label' => 'Nitrates'],
            ['key' => self::CARDIOVASCULAR_3, 'value' => self::CARDIOVASCULAR_3, 'label' => 'Atorvastatin (Lipitor)'],
            ['key' => self::CARDIOVASCULAR_4, 'value' => self::CARDIOVASCULAR_4, 'label' => 'Warfarin (Coumadin)'],
            ['key' => self::CARDIOVASCULAR_5, 'value' => self::CARDIOVASCULAR_5, 'label' => 'Other'],
        ];
    }

    public function getDiabetes()
    {
        return [
            ['key' => self::DIABETES_1, 'value' => self::DIABETES_1, 'label' => 'Lantus Solostar (insulin glargine) '],
            ['key' => self::DIABETES_2, 'value' => self::DIABETES_2, 'label' => 'Lyrica (pregabalin)'],
            ['key' => self::DIABETES_3, 'value' => self::DIABETES_3, 'label' => 'Januvia (sitagliptin) '],
            ['key' => self::DIABETES_4, 'value' => self::DIABETES_4, 'label' => 'NovoLog®/NovoRapid® (insulin aspart)'],
//            ['key' => self::DIABETES_5, 'value' => self::DIABETES_5, 'label' => 'Humalog® (insulin lispro injection),Victoza® (liraglutide)'],
//            ['key' => self::DIABETES_6, 'value' => self::DIABETES_6, 'label' => 'Metformin'],
//            ['key' => self::DIABETES_7, 'value' => self::DIABETES_7, 'label' => 'Glipizide'],
//            ['key' => self::DIABETES_8, 'value' => self::DIABETES_8, 'label' => 'Other'],
        ];
    }

    public function getDiabetesLevel()
    {
        return [
            ['key' => self::DIABETES_LEVEL_1, 'value' => self::DIABETES_LEVEL_1, 'label' => '5.7% and below'],
            ['key' => self::DIABETES_LEVEL_2, 'value' => self::DIABETES_LEVEL_2, 'label' => '5.7% to 6.4%'],
            ['key' => self::DIABETES_LEVEL_3, 'value' => self::DIABETES_LEVEL_3, 'label' => '6.4% to 7.5%'],
            ['key' => self::DIABETES_LEVEL_4, 'value' => self::DIABETES_LEVEL_4, 'label' => '7.5% and above'],
        ];
    }

    public function getThyroid()
    {
        return [
            ['key' => self::THYROID_1, 'value' => self::THYROID_1, 'label' => 'Levothyroxine (synthroid, levothyroid, levoxyl, unithroid)'],
            ['key' => self::THYROID_2, 'value' => self::THYROID_2, 'label' => 'Liothyronine (cytomel)'],
            ['key' => self::THYROID_3, 'value' => self::THYROID_3, 'label' => 'Liotrix (thyrolar)'],
            ['key' => self::THYROID_4, 'value' => self::THYROID_4, 'label' => 'Natural thyroid (armour thyroid, nature-throid, westhroid)'],
            ['key' => self::THYROID_5, 'value' => self::THYROID_5, 'label' => 'Other'],
        ];
    }

    public function getCholesterol()
    {
        return [
            ['key' => self::CHOLESTEROL_1, 'value' => self::CHOLESTEROL_1, 'label' => 'Crestor (rosuvastatin)'],
            ['key' => self::CHOLESTEROL_2, 'value' => self::CHOLESTEROL_2, 'label' => 'Atorvastatin (lipitor)'],
            ['key' => self::CHOLESTEROL_3, 'value' => self::CHOLESTEROL_3, 'label' => 'Fluvastatin (lescol)'],
//            ['key' => self::CHOLESTEROL_4, 'value' => self::CHOLESTEROL_4, 'label' => 'Pitavastatin (livalo)'],
//            ['key' => self::CHOLESTEROL_5, 'value' => self::CHOLESTEROL_5, 'label' => 'Pravastatin (pravachol)'],
            ['key' => self::CHOLESTEROL_6, 'value' => self::CHOLESTEROL_6, 'label' => 'Other'],
        ];
    }

    public function getBreathing()
    {
        return [
            ['key' => self::BEWATHING_1, 'value' => self::BEWATHING_1, 'label' => 'Ventolin HFA (albuterol)'],
            ['key' => self::BEWATHING_2, 'value' => self::BEWATHING_2, 'label' => 'Advair Diskus (fluticasone)'],
            ['key' => self::BEWATHING_3, 'value' => self::BEWATHING_3, 'label' => 'Spiriva Handihaler (tiotropium)'],
            ['key' => self::BEWATHING_4, 'value' => self::BEWATHING_4, 'label' => 'Other'],
        ];
    }

    public function getGastroesophageal()
    {
        return [
            ['key' => self::GASTROESOPHAGEAL_1, 'value' => self::GASTROESOPHAGEAL_1, 'label' => 'Nexium (esomeprazole)'],
            ['key' => self::GASTROESOPHAGEAL_2, 'value' => self::GASTROESOPHAGEAL_2, 'label' => 'Rabeprazole (aciphex)'],
            ['key' => self::GASTROESOPHAGEAL_3, 'value' => self::GASTROESOPHAGEAL_3, 'label' => 'Lansoprazole (prevacid)'],
//            ['key' => self::GASTROESOPHAGEAL_4, 'value' => self::GASTROESOPHAGEAL_4, 'label' => 'Omeprazole (prilosec, zegerid)'],
            ['key' => self::GASTROESOPHAGEAL_5, 'value' => self::GASTROESOPHAGEAL_5, 'label' => 'Other'],
        ];
    }

    public function getHyperactivity()
    {
        return [
            ['key' => self::HYPERACTIVITY_1, 'value' => self::HYPERACTIVITY_1, 'label' => 'Exedrine®, Vyvanse® (lisdexamfetamine)'],
            ['key' => self::HYPERACTIVITY_2, 'value' => self::HYPERACTIVITY_2, 'label' => 'Adderall (amphetamine)'],
//            ['key' => self::HYPERACTIVITY_3, 'value' => self::HYPERACTIVITY_3, 'label' => 'Ritalin®, Concerta,® Metadate®,Focalin®,Daytrana® (methylphenidate)'],
//            ['key' => self::HYPERACTIVITY_4, 'value' => self::HYPERACTIVITY_4, 'label' => 'Concerta (methylphenidate)'],
            ['key' => self::HYPERACTIVITY_5, 'value' => self::HYPERACTIVITY_5, 'label' => 'Other'],
        ];
    }

    public function getTreatWith()
    {
        return [
            ['key' => self::TREAT_WITH_1, 'value' => self::TREAT_WITH_1, 'label' => 'Viagra (sildenafil)'],
            ['key' => self::TREAT_WITH_2, 'value' => self::TREAT_WITH_2, 'label' => 'Levitra (vardenafil)'],
            ['key' => self::TREAT_WITH_3, 'value' => self::TREAT_WITH_3, 'label' => 'Cialis (tadalafil)'],
            ['key' => self::TREAT_WITH_4, 'value' => self::TREAT_WITH_4, 'label' => 'Other'],
        ];
    }

    public function getConfidenceRate()
    {
        return [
            ['key' => self::CONFIDENCE_RATE_1, 'value' => self::CONFIDENCE_RATE_1, 'label' => self::CONFIDENCE_RATE_1],
            ['key' => self::CONFIDENCE_RATE_2, 'value' => self::CONFIDENCE_RATE_2, 'label' => self::CONFIDENCE_RATE_2],
            ['key' => self::CONFIDENCE_RATE_3, 'value' => self::CONFIDENCE_RATE_3, 'label' => self::CONFIDENCE_RATE_3],
            ['key' => self::CONFIDENCE_RATE_4, 'value' => self::CONFIDENCE_RATE_4, 'label' => self::CONFIDENCE_RATE_4],
            ['key' => self::CONFIDENCE_RATE_5, 'value' => self::CONFIDENCE_RATE_5, 'label' => self::CONFIDENCE_RATE_5],
        ];
    }

    public function getSexualStimulation()
    {
        return [
            ['key' => self::SEXUAL_STIMULATION_1, 'value' => self::SEXUAL_STIMULATION_1, 'label' => 'Almost never or never'],
            ['key' => self::SEXUAL_STIMULATION_2, 'value' => self::SEXUAL_STIMULATION_2, 'label' => 'A few times (much less than half the time)'],
            ['key' => self::SEXUAL_STIMULATION_2, 'value' => self::SEXUAL_STIMULATION_2, 'label' => 'Sometimes (about half the time)'],
            ['key' => self::SEXUAL_STIMULATION_4, 'value' => self::SEXUAL_STIMULATION_4, 'label' => 'Most times (much more than half the time)'],
            ['key' => self::SEXUAL_STIMULATION_4, 'value' => self::SEXUAL_STIMULATION_4, 'label' => 'Almost always or always'],
        ];
    }

    public function getSexualDificult()
    {
        return [
            ['key' => self::SEXUAL_DIFICULT_1, 'value' => self::SEXUAL_DIFICULT_1, 'label' => 'Extremely difficult'],
            ['key' => self::SEXUAL_DIFICULT_2, 'value' => self::SEXUAL_DIFICULT_2, 'label' => 'Very difficult'],
            ['key' => self::SEXUAL_DIFICULT_3, 'value' => self::SEXUAL_DIFICULT_3, 'label' => 'Difficult'],
            ['key' => self::SEXUAL_DIFICULT_4, 'value' => self::SEXUAL_DIFICULT_4, 'label' => 'Slightly Difficult'],
            ['key' => self::SEXUAL_DIFICULT_5, 'value' => self::SEXUAL_DIFICULT_5, 'label' => 'Not Difficult'],
        ];
    }

    public function getPrimaryHealthGoal()
    {
        return [
            ['key' => self::PRIMARY_HEALTH_GOAL_1, 'value' => self::PRIMARY_HEALTH_GOAL_1, 'label' => self::PRIMARY_HEALTH_GOAL_1],
            ['key' => self::PRIMARY_HEALTH_GOAL_2, 'value' => self::PRIMARY_HEALTH_GOAL_2, 'label' => self::PRIMARY_HEALTH_GOAL_2],
            ['key' => self::PRIMARY_HEALTH_GOAL_3, 'value' => self::PRIMARY_HEALTH_GOAL_3, 'label' => self::PRIMARY_HEALTH_GOAL_3],
            ['key' => self::PRIMARY_HEALTH_GOAL_4, 'value' => self::PRIMARY_HEALTH_GOAL_4, 'label' => self::PRIMARY_HEALTH_GOAL_4],
            ['key' => self::PRIMARY_HEALTH_GOAL_5, 'value' => self::PRIMARY_HEALTH_GOAL_5, 'label' => self::PRIMARY_HEALTH_GOAL_5],
            ['key' => self::PRIMARY_HEALTH_GOAL_6, 'value' => self::PRIMARY_HEALTH_GOAL_6, 'label' => self::PRIMARY_HEALTH_GOAL_6],
            ['key' => self::PRIMARY_HEALTH_GOAL_7, 'value' => self::PRIMARY_HEALTH_GOAL_7, 'label' => self::PRIMARY_HEALTH_GOAL_7],

        ];
    }

    public function getEnergy()
    {
        return [
            ['key' => self::ENERGY_1, 'value' => self::ENERGY_1, 'label' => self::ENERGY_1],
            ['key' => self::ENERGY_2, 'value' => self::ENERGY_2, 'label' => self::ENERGY_2],
            ['key' => self::ENERGY_3, 'value' => self::ENERGY_3, 'label' => self::ENERGY_3],
            ['key' => self::ENERGY_4, 'value' => self::ENERGY_4, 'label' => self::ENERGY_4],
        ];

    }

    public function getSymptomAssessment()
    {
        return [
            ['key' => self::SYMPTOM_1, 'value' => self::SYMPTOM_1, 'label' => self::SYMPTOM_1],
            ['key' => self::SYMPTOM_2, 'value' => self::SYMPTOM_2, 'label' => self::SYMPTOM_2],
            ['key' => self::SYMPTOM_3, 'value' => self::SYMPTOM_3, 'label' => self::SYMPTOM_3],
            ['key' => self::SYMPTOM_4, 'value' => self::SYMPTOM_4, 'label' => self::SYMPTOM_4],
        ];
    }

    public function getExperience(){
        return [
            ['key' => self::EXPERIENCE_1, 'value' => self::EXPERIENCE_1, 'label' => self::EXPERIENCE_1],
            ['key' => self::EXPERIENCE_2, 'value' => self::EXPERIENCE_2, 'label' => self::EXPERIENCE_2],
            ['key' => self::EXPERIENCE_3, 'value' => self::EXPERIENCE_3, 'label' => self::EXPERIENCE_3],
            ['key' => self::EXPERIENCE_4, 'value' => self::EXPERIENCE_4, 'label' => self::EXPERIENCE_4],
            ['key' => self::EXPERIENCE_5, 'value' => self::EXPERIENCE_5, 'label' => self::EXPERIENCE_5],
            ['key' => self::EXPERIENCE_6, 'value' => self::EXPERIENCE_6, 'label' => self::EXPERIENCE_6],
            ['key' => self::EXPERIENCE_7, 'value' => self::EXPERIENCE_7, 'label' => self::EXPERIENCE_7],
            ['key' => self::EXPERIENCE_8, 'value' => self::EXPERIENCE_8, 'label' => self::EXPERIENCE_8],
            ['key' => self::EXPERIENCE_9, 'value' => self::EXPERIENCE_9, 'label' => self::EXPERIENCE_9],
            ['key' => self::EXPERIENCE_10, 'value' => self::EXPERIENCE_10, 'label' => self::EXPERIENCE_10],
        ];
    }


}
