from django.shortcuts import render
from django.contrib.auth.decorators import login_required

@login_required(login_url="login")
def dashboard_home(request):
    count_books = 4
    count_authors = 1
    return render(request, 'index.html', {
        "count_books": count_books,
        "count_authors": count_authors
    })
