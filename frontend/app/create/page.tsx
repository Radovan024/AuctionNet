"use client"

import { useState, useEffect } from 'react';

export default function Create() {
    const [naslov, setNaslov] = useState('');
    const [opis, setOpis] = useState('');
    const [slika, setSlika] = useState(null); // Novo stanje za sliku
    const [pocetnaCena, setPocetnaCena] = useState('');
    const [userId, setUserId] = useState('');

    useEffect(() => {
        const userData = JSON.parse(localStorage.getItem('userData'));
        if (userData && userData.id) {
            setUserId(userData.id);
        } else {
            // Handle the case where userData is not available
            console.error('User data not found in local storage');
        }
    }, []);

    const handleSubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData();
        formData.append('naslov', naslov);
        formData.append('opis', opis);
        formData.append('slika', slika); // Dodavanje slike u FormData
        formData.append('pocetnaCena', pocetnaCena);
        formData.append('userId', userId);

        try {
            const response = await fetch('http://127.0.0.1:8000/api/create', {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                const result = await response.json();
                console.log('Success:', result);
            } else {
                console.error('Error:', response.statusText);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    };

    return (
        <div>
            <h1>Create a New Post</h1>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>
                        Naslov:
                        <input type="text" value={naslov} onChange={(e) => setNaslov(e.target.value)} />
                    </label>
                </div>
                <div>
                    <label>
                        Opis:
                        <input type="text" value={opis} onChange={(e) => setOpis(e.target.value)} />
                    </label>
                </div>
                <div>
                    <label>
                        Slika:
                        <input type="file" onChange={(e) => setSlika(e.target.files[0])} />
                    </label>
                </div>
                <div>
                    <label>
                        Početna Cena:
                        <input type="number" value={pocetnaCena} onChange={(e) => setPocetnaCena(e.target.value)} />
                    </label>
                </div>
                <button type="submit">Create Post</button>
            </form>
        </div>
    );
}
