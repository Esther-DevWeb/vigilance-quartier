import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../api';

export default function IncidentDetail() {
  const { id } = useParams();
  const [incident, setIncident] = useState(null);

  useEffect(() => {
    api.get(`/incidents/${id}`).then((res) => setIncident(res.data));
  }, [id]);

  if (!incident) return <p>Chargement...</p>;

  return (
    <div>
      <h1>{incident.title}</h1>
      <p>{incident.description}</p>
      <p>Quartier : {incident.neighborhood}</p>
      <p>Gravité : {incident.severity}</p>
      <p>Statut : {incident.status}</p>
    </div>
  );
}
