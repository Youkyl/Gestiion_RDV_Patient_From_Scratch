package com.grdvp.service;

import com.grdvp.entity.DemandeRDV;
import com.grdvp.entity.Patient;
import com.grdvp.entity.Specialite;
import com.grdvp.entity.Statut;
import com.grdvp.repository.DemandeRDVRepositoryImpl;
import com.grdvp.repository.PatientRepositoryImpl;
import com.grdvp.service.interfaces.DemandeRDVServiceImpl;

import java.time.LocalDateTime;
import java.util.List;

public class DemandeRDVService implements DemandeRDVServiceImpl {

    private static DemandeRDVService instance;
    private final DemandeRDVRepositoryImpl demandeRepo;
    private final PatientRepositoryImpl patientRepo;

    private DemandeRDVService() {
        this.demandeRepo = DemandeRDVRepositoryImpl.getInstance();
        this.patientRepo = PatientRepositoryImpl.getInstance();
    }

    public static DemandeRDVService getInstance() {
        if (instance == null) {
            instance = new DemandeRDVService();
        }
        return instance;
    }

    /** Create a new DemandeRDV (in memory). Use registerDemandeRDV to persist. */
    public DemandeRDV createDemandeRDV(Patient patient, Specialite specialite, String description) {
        DemandeRDV d = new DemandeRDV();
        d.setPatient(patient);
        d.setPatientId(patient != null ? patient.getId() : null);
        d.setSpecialite(specialite);
        d.setDescription(description);
        d.setCreatedAt(LocalDateTime.now());
        d.setStatut(Statut.EN_COURS);
        return d;
    }

    @Override
    public void addDemand(DemandeRDV demande) {
        if (demande.getCreatedAt() == null) demande.setCreatedAt(LocalDateTime.now());
        if (demande.getStatut() == null) demande.setStatut(Statut.EN_COURS);
        demandeRepo.insertDemande(demande);
    }

    @Override
    public List<DemandeRDV> searchDemand(int patientId) {
        return demandeRepo.selectDemande(patientId);
    }

    @Override
    public List<DemandeRDV> searchApointment(int patientId) {
        return demandeRepo.selectAppointment(patientId);
    }

    @Override
    public List<DemandeRDV> filterDemandByStatus(String statut) {
        return demandeRepo.selectDemandeByStatut(statut);
    }

    @Override
    public DemandeRDV serchDemandeById(int demandeId) {
        return demandeRepo.findById(demandeId);
    }

    @Override
    public void changeDemandeStatut(DemandeRDV demande, Statut statut) {
        if (demande != null && demande.getId() != null) {
            demandeRepo.updateStatut(demande.getId(), statut);
            demande.setStatut(statut);
        }
    }

    @Override
    public List<DemandeRDV> getAllDemande() {
        return demandeRepo.findAll();
    }
}
