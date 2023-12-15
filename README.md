# Stackoverflow Api

Stackoverflow restful api where to get the data from the stackoverflow forums

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Create the Google cloud credentials file in the project root
6. Create .env file in the project root
7. Run `docker compose down --remove-orphans` to stop the Docker containers.

## HOW TO CREATE GOOGLE CLOUD CREDENTIALS CREDENTIALS 

1. Access the Google Cloud Console:
Navigate to the Google Cloud Console.

2. Create a Project:
If you don't have a project yet, create one from the top panel of the console. You can click on "Select project" and then "Create project."

3. Enable Necessary APIs:
Make sure to enable the APIs you need for your project. For services like BigQuery, you'll need to enable the BigQuery API. You can do this from the "APIs & Services" section in the console.

4. Create a Service Account:
In the Google Cloud Console, go to the "IAM & Admin" section and select "Service accounts." Then, click on "Create Service Account." Provide a name and an ID for the service account.

5. Assign Permissions:
After creating the service account, assign the necessary roles and permissions. You can assign predefined roles from Google Cloud (e.g., "Editor") or service-specific roles like "BigQuery Admin."

6. Create a Service Account Key:
After assigning permissions, select the service account from the list and click on "Create Key." Choose the key type you need (usually, a JSON key is used) and download it.

7. Save the Credentials:
Save the JSON file you downloaded with the service account credentials in a secure location. This file contains sensitive information and should be handled with care.

## HOW TO CREATE .ENV FILE

1. Create .env file in the project root
2. Create variable constant `PROJECT_ID` with your Google cloud project id

## Popular tags

shows the first 10 most popular tags of the year.

- **Endpoint: https://localhost/stackoverflow/tags/popular?year=2021**: 
- **Response**: {'Popular tags', ['tag' => 'Php', 'questions' => '1234567']}.
