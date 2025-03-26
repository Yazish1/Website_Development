export default async function handler(req, res) {
  // Enable CORS
  res.setHeader('Access-Control-Allow-Credentials', true);
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET,OPTIONS,PATCH,DELETE,POST,PUT');
  res.setHeader(
    'Access-Control-Allow-Headers',
    'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version'
  );

  if (req.method === 'POST') {
    try {
      const { email } = req.body;

      // Validate email
      if (!email || !email.includes('@')) {
        return res.status(400).json({ error: 'Invalid email address' });
      }

      // Here you would typically save to your database
      // For now, we'll just return success
      return res.status(200).json({
        message: 'Successfully subscribed to newsletter',
        email: email
      });
    } catch (error) {
      return res.status(500).json({ error: 'Error processing subscription' });
    }
  }

  return res.status(405).json({ error: 'Method not allowed' });
} 