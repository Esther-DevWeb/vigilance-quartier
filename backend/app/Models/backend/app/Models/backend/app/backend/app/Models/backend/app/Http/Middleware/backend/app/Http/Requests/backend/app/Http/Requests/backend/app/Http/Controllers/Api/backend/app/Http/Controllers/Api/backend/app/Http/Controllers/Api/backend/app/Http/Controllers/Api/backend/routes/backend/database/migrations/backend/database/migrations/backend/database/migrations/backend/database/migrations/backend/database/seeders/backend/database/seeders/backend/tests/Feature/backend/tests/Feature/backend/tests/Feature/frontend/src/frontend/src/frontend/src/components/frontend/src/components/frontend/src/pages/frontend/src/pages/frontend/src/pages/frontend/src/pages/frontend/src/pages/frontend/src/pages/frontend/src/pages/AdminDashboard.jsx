import { useEffect, useState } from 'react';
import api from '../api';

export default function AdminDashboard() {
  const [incidents, setIncidents] = useState([]);

  function load() {
    api.get('/admin/incidents').then((res) => setIncidents(res.data.data));
  }

  useEffect(() => { load(); }, []);

  function updateStatus(id, status) {
    api.patch(`/incidents/${id}/status`, { status }).then(load);
  }

  return (
    <div>
      <h1>Tableau de bord</h1>
      {incidents.map((incident) => (
        <div key={incident.id}>
          <h3>{incident.title}</h3>
          <p>{incident.status}</p>
          <button onClick={() => updateStatus(incident.id, 'valide')}>Valider</button>
          <button onClick={() => updateStatus(incident.id, 'rejete')}>Rejeter</button>
          <button onClick={() => updateStatus(incident.id, 'cloture')}>Clôturer</button>
        </div>
      ))}
    </div>
  );
}
