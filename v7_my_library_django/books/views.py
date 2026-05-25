from django.shortcuts import render, get_object_or_404, redirect
from django.contrib import messages
from django.contrib.auth.decorators import login_required
from django.http import JsonResponse

from authors.models import Author
from .models import Book

@login_required(login_url="login")
def book_list(request):
    books = Book.objects.select_related('author').all()
    count_books = Book.objects.count()
    return JsonResponse({
        "count_books": count_books
    })

@login_required(login_url="login")
def book_detail(request, book_id):
    return None

@login_required(login_url="login")
def book_form(request, book_id=None):
    return None

@login_required(login_url="login")
def book_create(request):
    return None

@login_required(login_url="login")
def book_edit(request, book_id):
    return None

@login_required(login_url="login")
def book_delete(request, book_id):
    return None

