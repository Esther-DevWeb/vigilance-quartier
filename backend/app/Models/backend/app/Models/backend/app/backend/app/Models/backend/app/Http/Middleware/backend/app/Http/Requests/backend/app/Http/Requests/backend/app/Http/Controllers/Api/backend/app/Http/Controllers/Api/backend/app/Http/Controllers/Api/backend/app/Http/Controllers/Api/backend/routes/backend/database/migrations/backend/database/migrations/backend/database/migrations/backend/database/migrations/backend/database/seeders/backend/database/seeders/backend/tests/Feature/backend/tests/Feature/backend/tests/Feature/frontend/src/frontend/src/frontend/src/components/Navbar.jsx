import { Link } from 'react-router-dom';

export default function Navbar() {
  const token = localStorage.getItem('token');

  function logout() {
    localStorage.removeItem('token');
    window.location.href = '/';
  }

  return (
    <nav>
      <Link to="/">Fil</Link>
      <Link to="/alertes">Alertes</Link>
      {token ? (
        <>
          <Link to="/signalements/nouveau">Signaler</Link>
          <Link to="/admin">Admin</Link>
          <button onClick={logout}>Déconnexion</button>
        </>
      ) : (
        <>
          <Link to="/login">Connexion</Link>
          <Link to="/register">Inscription</Link>
        </>
      )}
    </nav>
  );
}
