import { db } from '../utils/db';  // Adjust the path if needed for your Neon connection

export default async function handler(req, res) {
  if (req.method === 'POST') {
    const { uuhuhu, password } = req.body;
    
    // Query for room and password validation (just a simple example)
    try {
      const result = await db('portal').where({ uuhuhu, password }).first();
      
      if (result) {
        return res.status(200).json({ message: 'Access granted to the portal.' });
      } else {
        return res.status(403).json({ error: 'Invalid room number or password' });
      }
    } catch (error) {
      console.error(error);
      return res.status(500).json({ error: 'Failed to check portal access' });
    }
  } else {
    return res.status(405).json({ error: 'Method Not Allowed' });
  }
}
