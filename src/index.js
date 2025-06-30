import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { TextControl, PanelBody, Button } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import metadata from '../block.json';
import './index.css';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const [searchTerm, setSearchTerm] = useState('');
    const [postIdSearch, setPostIdSearch] = useState('');
    const [posts, setPosts] = useState([]);
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    const fetchPosts = async (search = '', id = '', pageNum = 1) => {
        setIsLoading(true);
        setError(null);
        try {
            let path = `/wp/v2/posts?per_page=10&page=${pageNum}&status=publish`;
            if (search) path += `&search=${encodeURIComponent(search)}`;
            if (id) path += `&include=${id}`;

            const response = await apiFetch({
                path,
                method: 'GET',
                parse: false,
            });

            const postsData = await response.json();
            setPosts(Array.isArray(postsData) ? postsData : []);
            setTotalPages(parseInt(response.headers.get('X-WP-TotalPages') || 1));
        } catch (error) {
            console.error('Error fetching posts:', error);
            setError('Failed to fetch posts. Please try again.');
            setPosts([]);
            setTotalPages(1);
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        fetchPosts('', '', 1);
    }, []);

    const selectPost = (post) => {
        setAttributes({
            postId: post.id,
            postTitle: post.title.rendered,
            postLink: post.link,
        });
        setSearchTerm('');
        setPostIdSearch('');
        setPage(1);
        fetchPosts('', '', 1);
    };

    const handleSearch = (value, type) => {
        if (type === 'title') {
            setSearchTerm(value);
            setPostIdSearch('');
        } else {
            setPostIdSearch(value);
            setSearchTerm('');
        }
        setPage(1);
        fetchPosts(type === 'title' ? value : '', type === 'id' && value.match(/^\d+$/) ? value : '', 1);
    };

    const changePage = (newPage) => {
        setPage(newPage);
        fetchPosts(searchTerm, postIdSearch, newPage);
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title="Post Selection">
                    <TextControl
                        label="Search by Post Title"
                        value={searchTerm}
                        onChange={(value) => handleSearch(value, 'title')}
                    />
                    <TextControl
                        label="Search by Post ID"
                        value={postIdSearch}
                        onChange={(value) => handleSearch(value, 'id')}
                    />
                    {isLoading && <p>Loading...</p>}
                    {error && <p style={{ color: 'red' }}>{error}</p>}
                    {!isLoading && !error && posts.length === 0 && (
                        <p>No posts found.</p>
                    )}
                    {!isLoading && !error && posts.length > 0 && (
                        <div>
                            {posts.map((post) => (
                                <Button
                                    key={post.id}
                                    variant="secondary"
                                    onClick={() => selectPost(post)}
                                    style={{
                                        display: 'block',
                                        margin: '5px 0',
                                        textAlign: 'left',
                                    }}
                                >
                                    {post.title.rendered} (ID: {post.id})
                                </Button>
                            ))}
                        </div>
                    )}
                    <div style={{ marginTop: '10px' }}>
                        <Button
                            variant="secondary"
                            disabled={page <= 1 || isLoading}
                            onClick={() => changePage(page - 1)}
                        >
                            Previous
                        </Button>
                        <Button
                            variant="secondary"
                            disabled={page >= totalPages || isLoading}
                            onClick={() => changePage(page + 1)}
                        >
                            Next
                        </Button>
                        <p style={{ display: 'inline', margin: '0 10px' }}>
                            Page {page} of {totalPages}
                        </p>
                    </div>
                </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                {attributes.postId ? (
                    <p className="dmg-read-more">
                        Read More: <a href={attributes.postLink}>{attributes.postTitle}</a>
                    </p>
                ) : (
                    <p>Select a post from the sidebar.</p>
                )}
            </div>
        </>
    );
}

export function Save({ attributes }) {
    return attributes.postId ? (
        <p className="dmg-read-more">
            Read More: <a href={attributes.postLink}>{attributes.postTitle}</a>
        </p>
    ) : null;
}

registerBlockType(metadata, {
    edit: Edit,
    save: Save,
});