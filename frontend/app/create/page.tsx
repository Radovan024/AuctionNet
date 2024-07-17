"use client"

import { useState, useEffect } from 'react';

export default function Create() {
    const [naslov, setNaslov] = useState('');
    const [opis, setOpis] = useState('');
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

        const data = {
            naslov,
            opis,
            pocetnaCena,
            userId,
        };

        try {
            const response = await fetch('http://127.0.0.1:8000/api/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
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
                        Početna Cena:
                        <input type="number" value={pocetnaCena} onChange={(e) => setPocetnaCena(e.target.value)} />
                    </label>
                </div>
                <button type="submit">Create Post</button>
            </form>
        </div>
    );
}
