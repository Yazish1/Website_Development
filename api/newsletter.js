import { db } from '../utils/db';  // Adjust the path if needed for your Neon connection

export default async function handler(req, res) {
  if (req.method === 'POST') {
    const { email } = req.body;
    
    // Insert email into the Neon database
    try {
      await db('newsletter_subscribers').insert({ email });
      return res.status(200).json({ message: 'Email successfully added to newsletter!' });
    } catch (error) {
      console.error(error);
      return res.status(500).json({ error: 'Failed to add email' });
    }
  } else {
    return res.status(405).json({ error: 'Method Not Allowed' });
  }
}
