import React, { useState, useEffect } from 'react';

export default function TomatoComponent() {
  const [tomato, setTomato] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch('/api/tomato.php', { cache: 'no-store' })
      .then(async (response) => {
        const text = await response.text();

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}: ${text}`);
        }

        try {
          return JSON.parse(text);
        } catch {
          throw new Error(`Invalid JSON response: ${text}`);
        }
      })
      .then((data) => {
        if (data.error) {
          setError(data.error);
        } else {
          setTomato(data);
        }
        setLoading(false);
      })
      .catch((err) => {
        console.error('Tomato fetch failed:', err);
        setError(err.message || 'Unknown error');
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Loading tomato data...</p>;
  if (error) return <p style={{ color: 'red' }}>Error: {error}</p>;

  return (
    <div style={{ padding: '20px', border: '1px solid #ccc', borderRadius: '8px' }}>
      <h2>Tomato Information (ID: 11)</h2>
      {/* This pre tag beautifully displays all columns from your SQL row */}
      <pre>{JSON.stringify(tomato, null, 2)}</pre>
    </div>
  );
}
