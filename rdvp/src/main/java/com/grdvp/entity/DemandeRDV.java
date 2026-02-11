package com.grdvp.entity;

import java.time.LocalDateTime;

public class DemandeRDV {
    private Integer id;
    private String description;
    private LocalDateTime createdAt;
    //private Integer patientId;
    private Patient patient;
    private Specialite specialite;
    private Statut statut;

    public DemandeRDV() {}


    public DemandeRDV(
        Patient patient,
        Specialite specialite,
        Integer id,
        String description,
        LocalDateTime createdAt,
        Statut statut)
    {
        this.id = id;
        this.description = description;
        this.createdAt = createdAt;
        this.patient = patient;
        this.specialite = specialite;
        this.statut = statut;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getPatientId() {
        int patientId = patient.getId();
        return patientId;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(LocalDateTime createdAt) {
        this.createdAt = createdAt;
    }

    public Patient getPatient() {
        return patient;
    }


    public Specialite getSpecialite() {
        return specialite;
    }

    public void setSpecialite(Specialite specialite) {
        this.specialite = specialite;
    }

    public Statut getStatut() {
        return statut;
    }

    public void setStatut(Statut statut) {
        this.statut = statut;
    }

    
    public String toString() {
        String createdAtString = (createdAt != null) ? createdAt.toString() : "null";
        String patientString = (patient != null) ? patient.toString() : "Patient";
        String specialiteString = (specialite != null) ? specialite.toString() : "Specialite";
        String statutString = (statut != null) ? statut.toString() : "null";
        return String.format(
            "DemandeRDV { id: %d, description: %s, createdAt: %s, patient: %s, specialite: %s, statut: %s }",
            id,
            (description != null) ? description : "null",
            createdAtString,
            patientString,
            specialiteString,
            statutString
        );
    }


    public void setPatient(Patient patient) {
        this.patient = patient;
    }
}