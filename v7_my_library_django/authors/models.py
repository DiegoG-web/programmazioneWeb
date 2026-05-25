from django.db import models

# Create your models here.
class Author(models.Model):
    name = models.CharField(max_length=100)
    surname = models.CharField(max_length=100)
    def __str__(self):
        return f"{self.name} {self.surname}"

    class Meta:
        db_table = "authors"
        ordering = ["surname", "name"]
