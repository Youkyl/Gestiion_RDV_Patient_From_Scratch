package com.grdvp.service.interfaces;

import com.grdvp.entity.Patient;
import java.time.LocalDate;
import java.util.List;

public interface PatientServiceImpl {
    void addPatient(Patient patient);
    void addPersonalInformation(Patient patient);
    void addMedicalHistory(Patient patient, List<String> medicalHistory);
    String generatePatientCode();
    Patient connexion(String email, String password);
    void completePatientInfo(Patient patient, LocalDate dateNaissance, String adresse);
    void addAntecedent(Patient patient, String antecedent);
    List<Patient> getAllPatien();
}
