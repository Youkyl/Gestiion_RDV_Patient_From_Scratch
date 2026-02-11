package com.grdvp.service;

import com.grdvp.entity.Patient;
import com.grdvp.repository.PatientRepositoryImpl;
import com.grdvp.service.interfaces.PatientServiceImpl;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ThreadLocalRandom;

public class PatientService implements PatientServiceImpl {

    private static PatientService instance;
    private final PatientRepositoryImpl patientRepo;

    private PatientService() {
        this.patientRepo = PatientRepositoryImpl.getInstance();
    }

    public static PatientService getInstance() {
        if (instance == null) {
            instance = new PatientService();
        }
        return instance;
    }

    public Patient createPatientCode(String lastname, String firstname, String phone, String email, String password) 
    {
        Patient patient = new Patient();
        patient.setLastname(lastname);
        patient.setFirstname(firstname);
        patient.setPhone(phone);
        patient.setEmail(email);
        patient.setPassword(password);
        
        return patient;
    }

    @Override
    public void addPatient(Patient patient) {
        if (patient.getPatientCode() == null || patient.getPatientCode().isEmpty()) {
            patient.setPatientCode(generatePatientCode());
        }
        if (patient.getCreatedAt() == null) {
            patient.setCreatedAt(LocalDateTime.now());
        }
        patientRepo.insertPatient(patient);
    }

    @Override
    public void addPersonalInformation(Patient patient) {
        patientRepo.updatePersonalInformation(patient);
    }

    @Override
    public void addMedicalHistory(Patient patient, List<String> medicalHistory) {
        patientRepo.updateMedicalHistory(patient, medicalHistory);
    }

    @Override
    public String generatePatientCode() {
        int nextNumber = patientRepo.getNextPatientCodeNumber(); 
        return String.format("PAT-%04d", nextNumber);
    }

    @Override
    public Patient connexion(String email, String password) {
        return patientRepo.findByEmailAndPassword(email, password);
    }

    @Override
    public void completePatientInfo(Patient patient, LocalDate dateNaissance, String adresse) {
        patient.setBirthday(dateNaissance);
        patient.setAddress(adresse);
        patientRepo.updatePersonalInformation(patient);
    }

    @Override
    public void addAntecedent(Patient patient, String antecedent) {
        List<String> history = patient.getMedicalHistory() != null ? new ArrayList<>(patient.getMedicalHistory()) : new ArrayList<>();
        history.add(antecedent);
        patient.setMedicalHistory(history);
        patientRepo.updateMedicalHistory(patient, history);
    }

    @Override
    public Patient getConnectedPatientInfo(Integer patientId) {
        return patientRepo.findById(patientId);
    }
}
