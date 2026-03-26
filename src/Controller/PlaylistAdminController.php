<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/playlist/admin')]
class PlaylistAdminController extends AbstractController
{
    #[Route('/', name: 'app_playlist_admin_index', methods: ['GET'])]
    public function index(PlaylistRepository $playlistRepository): Response
    {
        return $this->render('playlist_admin/index.html.twig', [
            'playlists' => $playlistRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_playlist_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($playlist);
            $entityManager->flush();

            return $this->redirectToRoute('app_playlist_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlist_admin/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_playlist_admin_show', methods: ['GET'])]
    public function show(Playlist $playlist): Response
    {
        return $this->render('playlist_admin/show.html.twig', [
            'playlist' => $playlist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_playlist_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Playlist $playlist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_playlist_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlist_admin/edit.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_playlist_admin_delete', methods: ['POST'])]
#[Route('/{id}', name: 'app_playlist_admin_delete', methods: ['POST'])]
public function delete(Request $request, Playlist $playlist, EntityManagerInterface $entityManager): Response
{
        if ($this->isCsrfTokenValid('delete' . $playlist->getId(), $request->request->get('_token'))) {
            $nbFormations = $entityManager
                ->getRepository(\App\Entity\Formation::class)
                ->count(['playlist' => $playlist]);

            if ($nbFormations > 0) {
                $this->addFlash('error', 'Suppression impossible : playlist non vide.');
            } else {
                $entityManager->remove($playlist);
                $entityManager->flush();
                $this->addFlash('success', 'Playlist supprimée.');
            }
        }

        return $this->redirectToRoute('app_playlist_admin_index');
    }
}