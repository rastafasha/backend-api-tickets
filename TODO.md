# TODO: Fix MethodNotAllowedHttpException for Event Routes

- [x] Update POST routes in `routes/api_routes/event.php` to use `Route::any()` for `event/store`, `event/update/{student}`, and `event/updatestatus/admin/{student}` to allow both GET and POST methods.
- [ ] Test the updated routes to ensure they handle GET requests without exceptions.
- [ ] If needed, adjust controller methods to handle GET parameters instead of POST data.
