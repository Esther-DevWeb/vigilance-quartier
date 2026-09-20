import { Link } from 'react-router-dom';

export default function IncidentCard({ incident }) {
  return (
    <div>
      <h3>
        <Link to={`/signalements/${incident.id}`}>{incident.title}</Link>
      </h3>
      <p>{incident.neighborhood} — {incident.severity}</p>
      <p>{incident.occurred_at}</p>
    </div>
  );
}
