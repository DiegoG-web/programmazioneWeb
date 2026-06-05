from django.shortcuts import render
from django.contrib.auth.decorators import login_required

from books.models import Book 
from authors.models import Author

@login_required(login_url="login")
def dashboard_home(request):
    count_books = Book.objects.count()
    count_authors = Author.objects.count()
    return render(request, 'list.html', {
        "count_books": count_books,
        "count_authors": count_authors
    })
