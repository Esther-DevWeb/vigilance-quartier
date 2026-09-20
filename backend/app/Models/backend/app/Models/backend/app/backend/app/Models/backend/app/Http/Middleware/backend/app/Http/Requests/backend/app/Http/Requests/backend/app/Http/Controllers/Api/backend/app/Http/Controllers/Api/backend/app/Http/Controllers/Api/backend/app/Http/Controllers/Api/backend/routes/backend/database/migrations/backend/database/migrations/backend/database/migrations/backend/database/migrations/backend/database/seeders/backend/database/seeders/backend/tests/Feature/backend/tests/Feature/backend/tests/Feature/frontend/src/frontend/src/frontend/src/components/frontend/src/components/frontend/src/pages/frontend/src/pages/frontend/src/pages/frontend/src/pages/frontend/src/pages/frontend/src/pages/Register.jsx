import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../api';

export default function Register() {
  const [form, setForm] = useState({ name: '', email: '', password: '' });
  const [errors, setErrors] = useState({});
  const navigate = useNavigate();

  function handleChange(e) {
    setForm({ ...form, [e.target.name]: e.target.value });
  }

  function handleSubmit(e) {
    e.preventDefault();
    api.post('/register', form)
      .then((res) => {
        localStorage.setItem('token', res.data.token);
        navigate('/');
      })
      .catch((err) => setErrors(err.response?.data?.errors || {}));
  }

  return (
    <div>
      <h1>Inscription</h1>
      <form onSubmit={handleSubmit}>
        <input name="name" placeholder="Nom" onChange={handleChange} value={form.name} />
        {errors.name && <p>{errors.name[0]}</p>}
        <input name="email" placeholder="E-mail" onChange={handleChange} value={form.email} />
        {errors.email && <p>{errors.email[0]}</p>}
        <input type="password" name="password" placeholder="Mot de passe" onChange={handleChange} value={form.password} />
        {errors.password && <p>{errors.password[0]}</p>}
        <button type="submit">Créer le compte</button>
      </form>
    </div>
  );
}
