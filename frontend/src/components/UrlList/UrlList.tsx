import { useState, useEffect } from "react";

export function UrlList() {
    const [filter, setFilter] = useState('private');

    return (
        <div className="w-screen h-screen px-8 sm:px-48 lg:px-64">
            <h1 className="font-medium text-4xl pt-24">
                Skracacz linków
            </h1>

            <button
                onClick={() => setFilter('public')}
                className={`btn ${filter === 'public' ? 'btn-active' : ''}`}
            >
                Publiczne linki
            </button>
            <button
                onClick={() => setFilter('private')}
                className={`btn ${filter === 'private' ? 'btn-active' : ''}`}
            >
                Twoje linki
            </button>
        </div>
    )
}
