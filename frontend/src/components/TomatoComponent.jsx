import React, { useState, useEffect } from 'react';

export default function TomatoComponent() {
  const [tomato, setTomato] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    // Fetch data from your PHP backend port (mapped to 8001 in your docker-compose)
    fetch('https://organic-space-meme-jjgjrgwv9grxh5w9g-8001.app.github.dev')
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
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
        setError(err.message);
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
