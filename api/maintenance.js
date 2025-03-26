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
      const { roomNumber, issue, description } = req.body;

      // Validate input
      if (!roomNumber || !issue || !description) {
        return res.status(400).json({ error: 'Missing required fields' });
      }

      // Here you would typically:
      // 1. Save to database
      // 2. Send email notification to maintenance team
      // 3. Create ticket in maintenance system
      
      return res.status(200).json({
        message: 'Maintenance request submitted successfully',
        ticket: {
          roomNumber,
          issue,
          description,
          timestamp: new Date().toISOString()
        }
      });
    } catch (error) {
      return res.status(500).json({ error: 'Error processing maintenance request' });
    }
  }

  return res.status(405).json({ error: 'Method not allowed' });
} 