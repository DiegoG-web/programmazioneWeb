from django.urls import path
from . import views
app_name = "books"

urlpatterns = [
    path("list/",                               views.book_list,        name="list"),
    path("details/<int:book_id>/",               views.book_details,      name="details"),
    path("form/",                               views.book_form,        name="form"),
    path("form/<int:book_id>/",                 views.book_form,        name="form"),
    path("create/",                             views.book_create,      name="create"),
    path("edit/<int:book_id>/",                 views.book_edit,        name="edit"),
    path("delete/<int:book_id>/",               views.book_delete,      name="delete")
]