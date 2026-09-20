import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../api';

export default function NewIncident() {
  const [types, setTypes] = useState([]);
  const [form, setForm] = useState({
    incident_type_id: '', title: '', description: '', neighborhood: '', severity: 'faible', occurred_at: '',
  });
  const [errors, setErrors] = useState({});
  const navigate = useNavigate();

  useEffect(() => {
    api.get('/incident-types').then((res) => setTypes(res.data));
  }, []);

  function handleChange(e) {
    setForm({ ...form, [e.target.name]: e.target.value });
  }

  function handleSubmit(e) {
    e.preventDefault();
    api.post('/incidents', form)
      .then(() => navigate('/'))
      .catch((err) => setErrors(err.response?.data?.errors || {}));
  }

  return (
    <div>
      <h1>Signaler un incident</h1>
      <form onSubmit={handleSubmit}>
        <select name="incident_type_id" onChange={handleChange} value={form.incident_type_id}>
          <option value="">Type d'incident</option>
          {types.map((t) => (
            <option key={t.id} value={t.id}>{t.name}</option>
          ))}
        </select>
        {errors.incident_type_id && <p>{errors.incident_type_id[0]}</p>}

        <input name="title" placeholder="Titre" onChange={handleChange} value={form.title} />
        {errors.title && <p>{errors.title[0]}</p>}

        <textarea name="description" placeholder="Description" onChange={handleChange} value={form.description} />
        {errors.description && <p>{errors.description[0]}</p>}

        <input name="neighborhood" placeholder="Quartier" onChange={handleChange} value={form.neighborhood} />
        {errors.neighborhood && <p>{errors.neighborhood[0]}</p>}

        <select name="severity" onChange={handleChange} value={form.severity}>
          <option value="faible">Faible</option>
          <option value="moyenne">Moyenne</option>
          <option value="elevee">Élevée</option>
        </select>

        <input type="datetime-local" name="occurred_at" onChange={handleChange} value={form.occurred_at} />
        {errors.occurred_at && <p>{errors.occurred_at[0]}</p>}

        <button type="submit">Envoyer</button>
      </form>
    </div>
  );
}
