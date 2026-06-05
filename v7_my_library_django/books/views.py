from django.shortcuts import render, get_object_or_404, redirect
from django.contrib import messages
from django.contrib.auth.decorators import login_required
from django.http import JsonResponse

from authors.models import Author
from .models import Book
from .forms import BookForm

@login_required(login_url="login")
def book_list(request):
    books = Book.objects.select_related("author").all()
    # count_books = Book.objects.count()
    # return JsonResponse({
    #     "count_books": count_books
    # })
    return render(request, 'list.html', {"books": books})



@login_required(login_url="login")
def book_details(request, book_id):
    book = get_object_or_404(Book.objects.select_related("author"), id=book_id)
    return render(request, 'details.html', {"book": book})


@login_required(login_url="login")
def book_form(request, book_id=None):
    book = None
    if(book_id):
        book = get_object_or_404(Book.objects.select_related("author"), id=book_id)

    form = BookForm(instance=book)
    #authors = Author.objects.all()
    return render(request, 'form.html', {"form": form, "book": book})



@login_required(login_url="login")
def book_create(request):
    if(request.method != 'POST'):
        return redirect("books:form")
    
    form = BookForm(request.POST)
    if not form.is_valid():
        messages.error(request, "Errore nella creazione del libro")
        return render(request, 'form.html', {
            "book": None,
            "form": form 
            })
    form.save()
    
    # title = request.POST.get("title")
    # author_id = request.POST.get("author")
    # year = request.POST.get("year")
    # price = request.POST.get("price")
    # author = get_object_or_404(Author, id=author_id)
    # book = Book()
    # book.title = title
    # book.author = author
    # book.year = year
    # book.price = price

    # book.save()
    messages.success(request, "Libro creato con successo")
    return redirect("books:list")


@login_required(login_url="login")
def book_edit(request, book_id):
    if(request.method != 'POST'):
        return redirect("books:form", book_id = book_id)
    
    if(request.method != 'POST'):
        return redirect("books:form", book_id = book_id)
    
    book = get_object_or_404(Book, id=book_id)
    form = BookForm(request.POST, instance=book)
    if not form.is_valid():
        messages.error(request, "Errore nella modifica del libro")
        return render(request, 'form.html', {
            "book": book,
            "form": form 
            })
    form.save()
    
    # title = request.POST.get("title")
    # author_id = request.POST.get("author")
    # year = request.POST.get("year")
    # price = request.POST.get("price")
    # author = get_object_or_404(Author, id=author_id)
    # book = get_object_or_404(Book, id=book_id)
    # book.title = title
    # book.author = author
    # book.year = year
    # book.price = price

    # book.save()
    messages.success(request, "Libro modificato con successo")
    return redirect("books:list")


@login_required(login_url="login")
def book_delete(request, book_id):
    if(request.method != 'POST'):
        return redirect("books:list")
    book = get_object_or_404(Book, id=book_id)
    book.delete()
    messages.success(request, "Libro eliminato con successo")
    return redirect("books:list")