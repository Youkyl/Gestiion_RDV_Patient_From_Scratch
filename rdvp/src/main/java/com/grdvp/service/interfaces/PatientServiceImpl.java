package com.grdvp.service.interfaces;

import com.grdvp.entity.Patient;
import java.time.LocalDate;
import java.util.List;

public interface PatientServiceImpl {
    void addPatient(Patient patient);
    void addPersonalInformation(Patient patient);
    void addMedicalHistory(Patient patient, List<String> medicalHistory);
    String generatePatientCode(Patient patient);
    /** Login: find patient by email and password (connexion) */
    Patient connexion(String email, String password);
    /** Complete patient with date of birth, address, phone */
    void completePatientInfo(Patient patient, LocalDate dateNaissance, String adresse, String telephone);
    /** Add one antecedent to patient's medical history */
    void addAntecedent(Patient patient, String antecedent);
    List<Patient> getAllPatien();
}
