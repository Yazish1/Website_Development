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
      const { roomNumber, password } = req.body;

      // Validate input
      if (!roomNumber || !password) {
        return res.status(400).json({ error: 'Missing required fields' });
      }

      // Here you would typically:
      // 1. Hash the password
      // 2. Save to database
      // 3. Generate JWT token for authentication
      
      return res.status(200).json({
        message: 'Portal access request processed',
        roomNumber: roomNumber
      });
    } catch (error) {
      return res.status(500).json({ error: 'Error processing portal access request' });
    }
  }

  return res.status(405).json({ error: 'Method not allowed' });
} 