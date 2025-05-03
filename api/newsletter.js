import { db } from '../utils/db'; // Your path is correct based on your structure

export default async function handler(req, res) {
  if (req.method === 'POST') {
    const { email } = req.body;

    if (!email) {
      return res.status(400).json({ error: 'Email is required' });
    }

    try {
      await db('newsletter_subscribers').insert({ email });
      return res.status(200).json({ message: 'Email successfully added to newsletter!' });
    } catch (error) {
      console.error('Database error:', error);
      return res.status(500).json({ error: 'Failed to add email to the database' });
    }
  } else {
    return res.status(405).json({ error: 'Method Not Allowed' });
  }
}
