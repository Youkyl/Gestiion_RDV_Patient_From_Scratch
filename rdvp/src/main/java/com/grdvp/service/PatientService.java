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

    @Override
    public void addPatient(Patient patient) {
        if (patient.getPatientCode() == null || patient.getPatientCode().isEmpty()) {
            patient.setPatientCode(generatePatientCode(patient));
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
    public String generatePatientCode(Patient patient) {
        final String chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        StringBuilder code = new StringBuilder(8);
        for (int i = 0; i < 8; i++) {
            code.append(chars.charAt(ThreadLocalRandom.current().nextInt(chars.length())));
        }
        return code.toString();
    }

    @Override
    public Patient connexion(String email, String password) {
        return patientRepo.findByEmailAndPassword(email, password);
    }

    @Override
    public void completePatientInfo(Patient patient, LocalDate dateNaissance, String adresse, String telephone) {
        patient.setBirthday(dateNaissance);
        patient.setAddress(adresse);
        patient.setPhone(telephone);
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
    public List<Patient> getAllPatien() {
        return patientRepo.findAll();
    }
}
