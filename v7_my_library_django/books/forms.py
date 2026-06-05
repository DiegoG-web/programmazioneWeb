from datetime import date
from decimal import Decimal
from django import forms
 
from authors.models import Author
from .models import Book
 
class BookForm(forms.ModelForm):
    title = forms.CharField(
        label="Titolo",
        required=True,
        max_length=255,
        error_messages={
            "required": "Il titolo è obbligatorio",
            "max_length": "Il titolo deve avere meno di 255 caratteri"
        },
        widget=forms.TextInput(attrs={
            "class": "form-control",
            "placeholder": "Inserire il titolo del libro"
        })
    )
    author = forms.ModelChoiceField(
        label="Autore",
        queryset=Author.objects.all(),
        required=True,
        empty_label="Seleziona autore",
        error_messages={
            "required": "L'autore è obbligatorio",
            "invalid_choice": "L'autore selezionato non è valido"
        },
        widget=forms.Select(attrs={
            "class": "form-select"
        })
        
    )
    year = forms.IntegerField(
        label="Anno di pubblicazione",
        required=True,
        min_value=1,
        max_value=date.today().year,
        error_messages={
            "required": "L'anno di pubblicazione è obbligatorio",
            "min_value": "L'anno di pubblicazione deve essere maggiore o uguale a 1",
            "max_value": f"L'anno di pubblicazione deve essere minore o uguale a {date.today().year}",
            "invalid": "Inserire un numero intero valido per l'anno di pubblicazione"
        },
        widget=forms.NumberInput(attrs={
            "class": "form-control",
            "placeholder": "Inserire l'anno di pubblicazione"
        })
    )
    price = forms.DecimalField(
        label="Prezzo",
        required=True,
        min_value=Decimal("0.00"),
        max_digits=10,
        decimal_places=2,
        error_messages={
            "required": "Il prezzo è obbligatorio",
            "min_value": "Il prezzo deve essere maggiore o uguale a 0.00",
            "max_digits": "Il prezzo deve avere al massimo 10 cifre totali",
            "decimal_places": "Il prezzo deve avere al massimo 2 cifre decimali",
            "invalid": "Inserire un numero decimale valido per il prezzo"
        },
        widget=forms.NumberInput(attrs={
            "class": "form-control",
            "placeholder": "Inserire il prezzo del libro",
            "step": "0.01"
        })
    )
    class Meta:
        model = Book
        fields = ["title", "author", "year", "price"]

        def clear_title(self):
            title = self.cleaned_data.get("title")
    
            if title:
                title = title.strip()
            
            if not title:
                raise forms.ValidationError("Il titolo non può essere vuoto")
            
            return title
        
        def clean_year(self):
            year = self.cleaned_data.get("year")
            if year is None:
                return year
            current_year = date.today().year
            if year < 1 or year > current_year:
                raise forms.ValidationError(f"L'anno di pubblicazione deve essere compreso tra 1 e {current_year}")
            return year