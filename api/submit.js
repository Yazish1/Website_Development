// In-memory storage for demonstration (in a real app, this would be a database)
let newsletterSubscribers = [];
let portalAccessRequests = [];

export default async function handler(req, res) {
  // Handle GET request - retrieve subscribers
  if (req.method === 'GET') {
    try {
      return res.status(200).json({
        message: 'Subscribers retrieved successfully',
        subscribers: newsletterSubscribers,
        portalRequests: portalAccessRequests
      });
    } catch (error) {
      return res.status(500).json({ message: 'Error retrieving data' });
    }
  }

  // Handle POST request - submit new data
  if (req.method === 'POST') {
    try {
      const data = req.body;
      
      // Store the data based on type
      if (data.type === 'newsletter') {
        newsletterSubscribers.push({
          email: data.email,
          subscribedAt: new Date().toISOString()
        });
      } else if (data.type === 'portal') {
        portalAccessRequests.push({
          roomNumber: data.roomNumber,
          requestedAt: new Date().toISOString()
        });
      }
      
      return res.status(200).json({ 
        message: 'Form submitted successfully',
        data: data 
      });
    } catch (error) {
      return res.status(500).json({ message: 'Error processing form submission' });
    }
  }

  // Handle other methods
  return res.status(405).json({ message: 'Method not allowed' });
} 