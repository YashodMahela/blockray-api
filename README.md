BlockRay API – Layered Request Flow
1. Request

Entry point of the API.

Usually handled via routes in routes/api.php.

Example: POST /api/v1/transactions.

Validates incoming data via FormRequest (StoreTransactionRequest).

Purpose: Ensure only valid data reaches your application.

2. Middleware

Sits between the client request and the controller.

Examples: auth:api, throttle, cors.

Purpose:

Authenticate users.

Limit request rate.

Transform request/response globally.

Example: Only logged-in users can create transactions.

3. Controller

Handles the request after middleware passes it.

Responsibilities:

Call Services to execute business logic.

Return API Resources for structured JSON responses.

Should contain minimal logic; acts as a bridge.

Example: TransactionController@store.

4. Service

Contains business logic.

Coordinates data flow between Repository, Jobs, Events, and Models.

Purpose:

Keep controllers clean.

Encapsulate domain-specific logic.

Example: TransactionService::createTransaction():

Generate transaction hash.

Dispatch a job to process the transaction asynchronously.

5. Repository (optional)

Handles database operations for a model.

Abstracts queries from service layer.

Purpose:

Makes database access reusable.

Makes testing easier (mock repository instead of hitting DB).

Example: TransactionRepository::getUserTransactions($userId).

6. Model

Represents database tables.

Handles relationships, fillable fields, and casts.

Example: Transaction model has user_id, amount, currency, status, tx_hash.

Purpose:

Provides Eloquent ORM features.

Encapsulates data structure.

7. Database (DB)

Stores persistent data.

Includes migrations, indexes, constraints for optimized queries.

Example: transactions table with indexes on user_id and status.

8. Event / Job

Events: Trigger actions based on certain application events.

Jobs: Execute tasks asynchronously in the background.

Purpose:

Offload heavy or delayed tasks.

Keep API responses fast.

Example: ProcessTransactionJob sends blockchain confirmation or notification after transaction creation.

9. Response (Resource)

Transforms models into structured JSON responses.

Example: TransactionResource returns:

{
  "id": 1,
  "amount": 0.005,
  "currency": "BTC",
  "status": "pending",
  "tx_hash": "tx_ab12cd34...",
  "created_at": "2025-09-20T21:00:00Z"
}


Purpose:

Keep API responses consistent.

Control exactly which data is exposed to clients.

🔹 Full Flow Recap

Client sends request → Request.

Middleware checks → Authentication, Throttle, CORS.

Controller receives request → minimal logic, calls Service.

Service handles business logic → may call Repository/Jobs/Events.

Repository interacts with DB → CRUD operations.

Model maps DB data → Eloquent ORM.

Job/Event handles async tasks → notifications, blockchain confirmations.

Controller returns Resource → JSON response to client.