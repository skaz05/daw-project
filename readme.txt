Student: Sebastian TETIC
Anul III Info ID, grupa 1

Tema aleasa: 'Activitatile unei agentii de turism'

Ca si structura, am optat pentru o functionalitate mai simpla

Pagini:
1. Welcome / Home Page
2. Tours / Trips Page
3. Cart / Transaction Page
4. User-related pages
    4.a. Register
    4.b. Login
    4.c. Logout (cu destroy de sesiune)
5. Pagina de administrare (incompleta)

Tabele db:
    1. USERS
    2. TOURS
    3. CART
    4. TRANSACTIONS
    5. TRANSACTION_ITEMS
    6. RECEIPTS

Operatii ce pot fi facute de user:
    - Cart-related
        Add to cart (adauga/creaza intrari in tabela cart)  - C
        Retrieve cart from database ()                      - R
        Update cart (modifica intrari din tabela cart)      - U
        Remove from cart (sterge intrari din tabela cart)   - D
    - User-related
        Create new user (in tabela users)
        * Delete self (inca nu e implementat in dashboard)
        * Contact (cu mail - neimplementat + pagina de contact)
    - * Admin-related
        * Add trip/tour
        * Remove trip/tour
        * Update existing trip/tour (description, price, name)

Obs.:
    Simbolul (*) reprezinta idei de implementare pe viitor, astfel incat feature-ul respectiv inca nu a fost adaugat 