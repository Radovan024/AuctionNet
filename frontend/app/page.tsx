"use client"

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";

export default function Home() {
    const router = useRouter();
    const [token, setToken] = useState("");

    useEffect(() => {
        // Fetch token from localStorage on component mount
        const storedToken = localStorage.getItem("token");
        if (storedToken) {
            setToken(storedToken);
            console.log(storedToken)
        } else {
            setToken(null); // Set token to null if not found
            // Optionally redirect to login page
            // router.push('/login');
        }
    }, []);

    const handleLogout = () => {
        // Clear token from localStorage and redirect to login page
        localStorage.removeItem("token");
        router.push('/login');
    };

    return (
        <div className="flex min-h-full flex-1 flex-col justify-center items-center px-6 py-12 lg:px-8">
            <h2 className="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Welcome to Your App
            </h2>
            {token ? (
                <div className="mt-4">
                    <p className="text-gray-700">Your token:</p>
                    <pre className="mt-2 p-2 bg-gray-100 rounded-md">{token}</pre>
                </div>
            ) : (
                <p className="mt-4 text-gray-700">No token found. Please login.</p>
            )}
            <button
                onClick={handleLogout}
                className="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
            >
                Logout
            </button>
        </div>
    );
}
