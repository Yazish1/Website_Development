import { db } from '../utils/db';  // Adjust the path if needed for your Neon connection

export default async function handler(req, res) {
  if (req.method === 'POST') {
    const { name, message } = req.body;
    
    // Insert feedback into the Neon database
    try {
      await db('feedback').insert({ name, message });
      return res.status(200).json({ message: 'Thank you for your feedback!' });
    } catch (error) {
      console.error(error);
      return res.status(500).json({ error: 'Failed to submit feedback' });
    }
  } else {
    return res.status(405).json({ error: 'Method Not Allowed' });
  }
}

