import { useEffect, useState } from 'react';
import api from '../api';
import IncidentCard from '../components/IncidentCard';

export default function Feed() {
  const [incidents, setIncidents] = useState([]);
  const [neighborhood, setNeighborhood] = useState('');

  useEffect(() => {
    api.get('/incidents', { params: { neighborhood } }).then((res) => {
      setIncidents(res.data.data);
    });
  }, [neighborhood]);

  return (
    <div>
      <h1>Fil des signalements</h1>
      <input
        placeholder="Filtrer par quartier"
        value={neighborhood}
        onChange={(e) => setNeighborhood(e.target.value)}
      />
      {incidents.map((incident) => (
        <IncidentCard key={incident.id} incident={incident} />
      ))}
    </div>
  );
}
