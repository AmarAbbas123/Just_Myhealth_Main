<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserType30Attributes extends Model
{
    use HasFactory;

    protected $table = 'sys_user_type_30_attributes';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'BioPhotoPath',
        'BioBackgroundPhotoPath',
        'BioTextParagraph1',
        'BioTextParagraph2',
        'BioTextParagraph3',
        'BioTextParagraph4',
        'BioTextParagraph5',
        'BioTextParagraph6',
        'PreferredSalutation',
        'LanguagePrimary',
        'LanguageSecondary',
        'VerificationPassportImagePath',
        'VerificationBACPCardImagePath',
        'VerificationLiabilityInsuranceImagePath',
        'VerificationDBSImagePath',
        'QualificationTitle1',
        'QualificationFrom1',
        'QualificationLevel1',
        'QualificationGrade1',
        'QualificationDateComplete1',
        'QualificationImagePath1',
        'QualificationTitle2',
        'QualificationFrom2',
        'QualificationLevel2',
        'QualificationGrade2',
        'QualificationDateComplete2',
        'QualificationImagePath2',
        'QualificationTitle3',
        'QualificationFrom3',
        'QualificationLevel3',
        'QualificationGrade3',
        'QualificationDateComplete3',
        'QualificationImagePath3',
        'QualificationTitle4',
        'QualificationFrom4',
        'QualificationLevel4',
        'QualificationGrade4',
        'QualificationDateComplete4',
        'QualificationImagePath4',
        'TherapyType1',
        'TherapyYearsExperience1',
        'TherapyType2',
        'TherapyYearsExperience2',
        'TherapyType3',
        'TherapyYearsExperience3',
        'TherapyType4',
        'TherapyYearsExperience4',
        'TherapyType5',
        'TherapyYearsExperience5',
        'VerifierID',
        'VerificationStatus',
        'VerifierNotes',
        'VerificationDate',
        'ApproverID',
        'ApprovalStatus',
        'ApproverNotes',
        'ApprovalDate'
    ];
}
