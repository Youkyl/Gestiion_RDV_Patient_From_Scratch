package com.grdvp.service.interfaces;

import com.grdvp.entity.DemandeRDV;
import com.grdvp.entity.Statut;
import java.util.List;

public interface DemandeRDVServiceImpl {
    void addDemand(DemandeRDV demande);
    List<DemandeRDV> searchDemand(int patientId);
    List<DemandeRDV> filterDemandByStatus(String statut);
    List<DemandeRDV> searchApointment(int patientId);
    DemandeRDV serchDemandeById(int demandeId);
    void changeDemandeStatut(DemandeRDV demande, Statut statut);
    List<DemandeRDV> getAllDemande();
}
