import { Pool } from 'pg';

const pool = new Pool({ connectionString: process.env.DATABASE_URL });

export default async function handler(req, res) {
  const { email } = req.query;
  if (!email) return res.status(400).json({ error: 'Email required' });

  try {
    await pool.query(
      `INSERT INTO newsletter_subscribers (email) VALUES ($1)
       ON CONFLICT (email) DO NOTHING`,
      [email]
    );
    res.status(200).json({ message: 'Subscribed!' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Database error' });
  }
}
 