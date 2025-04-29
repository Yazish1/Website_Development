# Database Setup with Neon DB

This document provides instructions on how to connect your application to a Neon DB PostgreSQL database.

## Step 1: Create a Neon DB Account and Database

1. Sign up for a Neon DB account at [neon.tech](https://neon.tech)
2. Create a new project (this will be your database)
3. Once created, you'll get connection details including:
   - Connection string
   - Username
   - Password
   - Host

## Step 2: Set Up Environment Variables

### For Local Development

Create a `.env` file in the root of your project with the following content:

```
DB_HOST=your-neon-db-host.neon.tech
DB_USERNAME=your-username
DB_PASSWORD=your-password
DB_NAME=your-database-name
DB_PORT=5432
```

Replace the placeholder values with your actual Neon DB credentials.

### For Vercel Deployment

1. Go to your Vercel project dashboard
2. Navigate to Settings > Environment Variables
3. Add the following environment variables:
   - `DB_HOST`
   - `DB_USERNAME`
   - `DB_PASSWORD`
   - `DB_NAME`
   - `DB_PORT`

## Step 3: Initialize the Database

1. Connect to your Neon DB database using the SQL Editor in the Neon DB dashboard
2. Copy the contents of `api/setup_database.sql`
3. Execute the SQL script to create the necessary tables

## Step 4: Test the Connection

1. Run your application locally
2. Test the forms to ensure they're correctly connecting to the database

## Troubleshooting

- If you encounter connection issues, verify your environment variables are correctly set
- Check that your Neon DB project is active and not in sleep mode
- Ensure your IP address is allowed in the Neon DB security settings if you've enabled IP restrictions 