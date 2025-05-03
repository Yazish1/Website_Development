import { Pool } from 'pg';

const pool = new Pool({ connectionString: process.env.DATABASE_URL });

export default async function handler(req, res) {
  if (req.method !== 'POST')
    return res.status(405).json({ error: 'Only POST allowed' });

  const { name, message } = req.body;
  if (!message) return res.status(400).json({ error: 'Message required' });

  try {
    await pool.query(
      'INSERT INTO feedback (name, message) VALUES ($1, $2)',
      [name || null, message]
    );
    res.status(200).json({ message: 'Thanks for your feedback!' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Database error' });
  }
}
