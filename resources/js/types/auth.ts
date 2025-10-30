// utils/auth.ts
import type { Auth } from '@/types';

export type UserRole = 'Administrateur' | 'Student' | 'Parent' | 'Comptable' | 'Assistant' | 'Surveillant' | 'DG';
// Fonction générique de vérification
export function hasRole(auth: Auth, role: UserRole): boolean {
    return auth.user.role === role;
}

// Fonctions spécifiques (implémentées via la fonction générique)
export const isAdmin = (auth: Auth): boolean => hasRole(auth, 'Administrateur');
export const isStudent = (auth: Auth): boolean => hasRole(auth, 'Student');
export const isParent = (auth: Auth): boolean => hasRole(auth, 'Parent');
export const isComptable = (auth: Auth): boolean => hasRole(auth, 'Comptable');
export const isAssistant = (auth: Auth): boolean => hasRole(auth, 'Assistant');
export const isSurveillant = (auth: Auth): boolean => hasRole(auth, 'Surveillant');
export const isDG = (auth: Auth): boolean => hasRole(auth, 'DG');

// Alternative sous forme d'objet (plus lisible dans certains cas)
export const Role = {
    admin: (auth: Auth) => hasRole(auth, 'Administrateur'),
    // superuser: (auth: Auth) => hasRole(auth, 'Superviseur'),
    student: (auth: Auth) => hasRole(auth, 'Student'),
    parent: (auth: Auth) => hasRole(auth, 'Parent'),
    comptable: (auth: Auth) => hasRole(auth, 'Comptable'),
    assistant: (auth: Auth) => hasRole(auth, 'Assistant'),
    surveillant: (auth: Auth) => hasRole(auth, 'Surveillant'),
    dg: (auth: Auth) => hasRole(auth, 'DG'),
    check: hasRole // Alias pour la fonction générique
};
