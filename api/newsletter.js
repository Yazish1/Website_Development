import { db } from '../utils/db';

export default async function handler(req, res) {
  if (req.method === 'POST') {
    const { email } = req.body;

    if (!email) {
      return res.status(400).json({ error: 'Email is required' });
    }

    try {
      const subscriptionDate = new Date().toISOString();  // ISO timestamp
      await db('newsletter_subscribers').insert({
        email,
        subscription_date: subscriptionDate,
      });

      return res.status(200).json({ message: 'Email successfully added to newsletter!' });
    } catch (error) {
      console.error('❌ DB insert failed:', error.message);
      return res.status(500).json({ error: `DB insert error: ${error.message}` });
    }
  } else {
    return res.status(405).json({ error: 'Method Not Allowed' });
  }
}

