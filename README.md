# Aplikacja do Zapisywania się na Korepetycje

## Opis

Aplikacja do zapisywania się na korepetycje to narzędzie, które umożliwia użytkownikom łatwe i wygodne rejestracje na prywatne lekcje. Aplikacja ma na celu ułatwienie procesu zarówno dla uczniów, jak i nauczycieli, zapewniając przejrzysty sposób umawiania się na korepetycje.

### Funkcje Aplikacji

- **Rejestracja Użytkownika:**
  1. Utwórz, podając swoje dane kontaktowe.
  2. Hashowanie danych Bcrypt
     ### Panel Rejestracji
      ![Panel Rejestracji](./readme_images/registration.png)

- **Umawianie się na Korepetycje:**
  1. Uczniowie mogą przeglądać dostępnych nauczycieli i terminy.
  2. Wybierz nauczyciela i termin, który ci odpowiada.
  3. Potwierdź rezerwację.
     ### Panel Umawiania się na korepetycje
      ![Główny panel](./readme_images/applying_for_tutorings.png)

  - **Panel tworzenie korepetycji:**
    1. Szybko i wygodnie twórz nowe korepetycje dla swoich uczniów.
       ### Panel tworzenia korepetycji
      ![Panel tworzenia korepetycji](./readme_images/adding_tutorings.png)

- **Kalendarz i Powiadomienia:**
  - Użytkownicy mogą śledzić swoje korepetycje w kalendarzu.
  - Otrzymuj powiadomienia o nadchodzących lekcjach.

- **Edycja Danych Użytkownika:**
  - Użytkownicy mogą edytować swoje dane, dostosowując je do bieżących potrzeb.
     ### Edycja Danych Osobistych
      ![Panel Profilu](./readme_images/profile_customization.png)

- **Panel Administracyjny:**
  - Istnieje panel administracyjny umożliwiający zarządzanie użytkownikami, korepetycjami i innymi aspektami aplikacji.
    ### Panel Administracyjny
      ![Panel Administracyjny](./readme_images/deletion_panel.png)

## Diagramy ERD

### Ogólny Diagram ERD
![Diagram ERD](./readme_images/erd.png)

### Diagramy Relacji
- **Many-to-Many:**
  ![Many-to-Many](./readme_images/many_to_many.png)

- **One-to-Many:**
  ![Many-to-One](./readme_images/one_to_many.png)


- **One-to-One:**
  ![One-to-One](./readme_images/one_to_one.png)
