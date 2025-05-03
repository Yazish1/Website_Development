import { Pool } from 'pg';
import bcrypt from 'bcryptjs';

const pool = new Pool({ connectionString: process.env.DATABASE_URL });

export default async function handler(req, res) {
  if (req.method !== 'POST')
    return res.status(405).json({ error: 'Only POST allowed' });

  const { roomNumber, password } = req.body;
  if (!roomNumber || !password)
    return res.status(400).json({ error: 'Missing fields' });

  try {
    const { rows } = await pool.query(
      'SELECT password_hash FROM residents WHERE room_number = $1',
      [roomNumber]
    );
    if (rows.length === 0)
      return res.status(404).json({ error: 'Room not found' });

    const match = await bcrypt.compare(password, rows[0].password_hash);
    if (!match) return res.status(401).json({ error: 'Invalid password' });

    res.status(200).json({ message: 'Access granted!' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Database error' });
  }
}
