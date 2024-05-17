import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';
import './index.css';
import 'bootstrap/dist/css/bootstrap.min.css'; // Import Bootstrap CSS
import Login from './components/Login';
import ProductTable from './components/ProductTable';

function App() {
    const [isAuthenticated, setIsAuthenticated] = useState(!!localStorage.getItem('token'));

    const handleLogin = () => {
        setIsAuthenticated(true);
    };

    return (
        <Router>
            <Routes>
                <Route
                    path="/login"
                    element={isAuthenticated ? <Navigate to="/products" /> : <Login onLogin={handleLogin} />}
                />
                <Route
                    path="/products"
                    element={isAuthenticated ? <ProductTable /> : <Navigate to="/login" />}
                />
                <Route path="/" element={<Navigate to="/login" />} />
            </Routes>
        </Router>
    );
}

export default App;
