import { useEffect, useState } from 'react';
import api from '../api';

export default function Alerts() {
  const [alerts, setAlerts] = useState([]);

  useEffect(() => {
    api.get('/alerts').then((res) => setAlerts(res.data.data));
  }, []);

  return (
    <div>
      <h1>Alertes officielles</h1>
      {alerts.map((alert) => (
        <div key={alert.id}>
          <h3>{alert.title}</h3>
          <p>{alert.message}</p>
          <p>{alert.urgency} — {alert.neighborhood}</p>
        </div>
      ))}
    </div>
  );
}
